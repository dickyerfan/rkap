<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pendapatan_air extends CI_Model
{
    public function getDataPendapatanAir($tahun, $upk = null)
    {
        // Ambil baris per bulan per jenis pelanggan dari rkap_pelanggan (id_kd = 6)
        $this->db->select("
        p.id_upk,
        u.nama_upk,
        p.id_jp,
        jp.nama_jp,
        p.bulan,
        p.jumlah AS pelanggan_akhir,
        COALESCE(pk.konsumsi_rata, 0) AS konsumsi_rata,
        COALESCE(tr.tarif_rata, 0) AS tarif_rata,
        COALESCE(jt.jasa_pemeliharaan, 0) AS jasa_pemeliharaan,
        COALESCE(jt.jasa_admin, 0) AS jasa_admin
    ");
        $this->db->from('rkap_pelanggan p');
        $this->db->join('rkap_nama_upk u', 'u.id_upk = p.id_upk', 'left');
        $this->db->join('rkap_jenis_plgn jp', 'jp.id_jp = p.id_jp', 'left');
        $this->db->join('rkap_pola_konsumsi pk', 'pk.id_upk = p.id_upk AND pk.id_jp = p.id_jp AND pk.tahun = p.tahun', 'left');
        $this->db->join('rkap_tarif_rata tr', 'tr.id_upk = p.id_upk AND tr.id_jp = p.id_jp AND tr.tahun = p.tahun', 'left');
        $this->db->join('rkap_jasa_tambahan jt', 'jt.id_upk = p.id_upk AND jt.id_jp = p.id_jp AND jt.tahun = p.tahun', 'left');

        $this->db->where('p.tahun', $tahun);
        $this->db->where('p.id_kd', 6); // sambungan akhir

        if ($upk) {
            $this->db->where('p.id_upk', $upk);
        }

        $this->db->order_by('jp.id_jp', 'ASC');
        $rows = $this->db->get()->result_array();

        $nama_upk = !empty($rows) ? $rows[0]['nama_upk'] : '';

        // struktur per jenis pelanggan
        $data = [];

        // temporary accumulators per jenis per bulan
        // we'll keep:
        // pelanggan_sum[b] = sum pelanggan
        // pola_num[b] = sum(pelanggan * konsumsi) -> for weighted avg
        // tarif_num[b] = sum(pelanggan * tarif) -> for weighted avg
        // penjualan_sum[b] = sum(pelanggan * konsumsi * tarif)
        // jasa_admin_sum[b] = sum(pelanggan * jasa_admin)
        // jasa_pem_sum[b] = sum(pelanggan * jasa_pemeliharaan)
        foreach ($rows as $r) {
            $jp = $r['nama_jp'] ?? 'LAINNYA';
            $bulan = (int)$r['bulan'];
            if ($bulan < 1 || $bulan > 12) $bulan = 1;

            if (!isset($data[$jp])) {
                $data[$jp] = [
                    'Pelanggan Akhir'   => array_fill(1, 12, 0),
                    'Pola Konsumsi'     => array_fill(1, 12, 0), // will fill weighted avg later
                    'Tarif Rata'        => array_fill(1, 12, 0), // will fill weighted avg later
                    'Penjualan Air'     => array_fill(1, 12, 0),
                    'Jasa Pemeliharaan' => array_fill(1, 12, 0),
                    'Jasa Administrasi' => array_fill(1, 12, 0),
                    'Tagihan Air'       => array_fill(1, 12, 0),
                    // internal accumulators:
                    '_acc' => [
                        'pel' => array_fill(1, 12, 0),
                        'pola_num' => array_fill(1, 12, 0),
                        'tarif_num' => array_fill(1, 12, 0),
                        'penjualan' => array_fill(1, 12, 0),
                        'jasa_admin' => array_fill(1, 12, 0),
                        'jasa_pem' => array_fill(1, 12, 0)
                    ]
                ];
            }

            $pel = (float)$r['pelanggan_akhir'];
            $pola = (float)$r['konsumsi_rata'];
            $tarif = (float)$r['tarif_rata'];
            $jp_jasa_pem = (float)$r['jasa_pemeliharaan'];
            $jp_jasa_adm = (float)$r['jasa_admin'];

            // per-row penjualan and jasa (note: jasa harus dikali jumlah pelanggan)
            $penjualan_row = $pel * $pola * $tarif;
            $jasa_pem_amount = $pel * $jp_jasa_pem;
            $jasa_adm_amount = $pel * $jp_jasa_adm;

            // accumulators
            $data[$jp]['_acc']['pel'][$bulan] += $pel;
            $data[$jp]['_acc']['pola_num'][$bulan] += $pel * $pola;
            $data[$jp]['_acc']['tarif_num'][$bulan] += $pel * $tarif;
            $data[$jp]['_acc']['penjualan'][$bulan] += $penjualan_row;
            $data[$jp]['_acc']['jasa_admin'][$bulan] += $jasa_adm_amount;
            $data[$jp]['_acc']['jasa_pem'][$bulan] += $jasa_pem_amount;
        }

        // finalize: compute weighted averages and totals per jenis per bulan
        $total = [
            'Pelanggan Akhir'   => array_fill(1, 12, 0),
            'Pola Konsumsi'     => array_fill(1, 12, 0),
            'Tarif Rata'        => array_fill(1, 12, 0),
            'Penjualan Air'     => array_fill(1, 12, 0),
            'Jasa Pemeliharaan' => array_fill(1, 12, 0),
            'Jasa Administrasi' => array_fill(1, 12, 0),
            'Tagihan Air'       => array_fill(1, 12, 0),
        ];
        foreach ($data as $jp => &$block) {
            for ($m = 1; $m <= 12; $m++) {
                $pel_sum = $block['_acc']['pel'][$m];
                // Pelanggan Akhir (jumlah)
                $block['Pelanggan Akhir'][$m] = (int) $pel_sum;

                // pola konsumsi = weighted avg (pel * pola) / pel_sum
                $block['Pola Konsumsi'][$m] = $pel_sum > 0 ? ($block['_acc']['pola_num'][$m] / $pel_sum) : 0;

                // tarif rata = weighted avg (pel * tarif) / pel_sum
                $block['Tarif Rata'][$m] = $pel_sum > 0 ? ($block['_acc']['tarif_num'][$m] / $pel_sum) : 0;

                // penjualan air (sum)
                $block['Penjualan Air'][$m] = $block['_acc']['penjualan'][$m];

                // jasa sums (already multiplied by pel)
                $block['Jasa Pemeliharaan'][$m] = $block['_acc']['jasa_pem'][$m];
                $block['Jasa Administrasi'][$m] = $block['_acc']['jasa_admin'][$m];

                // tagihan air
                $block['Tagihan Air'][$m] = $block['Penjualan Air'][$m] + $block['Jasa Pemeliharaan'][$m] + $block['Jasa Administrasi'][$m];

                // === akumulasi ke TOTAL ===
                $total['Pelanggan Akhir'][$m]   += $block['Pelanggan Akhir'][$m];
                $total['Pola Konsumsi'][$m]     += $block['Pola Konsumsi'][$m] * $block['Pelanggan Akhir'][$m]; // weighted
                $total['Tarif Rata'][$m]        += $block['Tarif Rata'][$m] * $block['Pelanggan Akhir'][$m];   // weighted
                $total['Penjualan Air'][$m]     += $block['Penjualan Air'][$m];
                $total['Jasa Pemeliharaan'][$m] += $block['Jasa Pemeliharaan'][$m];
                $total['Jasa Administrasi'][$m] += $block['Jasa Administrasi'][$m];
                $total['Tagihan Air'][$m]       += $block['Tagihan Air'][$m];
            }
            // drop internal accumulator to keep return clean
            unset($block['_acc']);
        }
        // hitung rata-rata konsumsi dan tarif
        for ($m = 1; $m <= 12; $m++) {
            $pel_sum = $total['Pelanggan Akhir'][$m];
            if ($pel_sum > 0) {
                $total['Pola Konsumsi'][$m] = $total['Pola Konsumsi'][$m] / $pel_sum;
                $total['Tarif Rata'][$m]    = $total['Tarif Rata'][$m] / $pel_sum;
            }
        }
        unset($r, $rows);

        // return $data;
        return [
            'nama_upk' => $nama_upk,
            'data'     => $data,
            'total'    => $total
        ];
    }
}
