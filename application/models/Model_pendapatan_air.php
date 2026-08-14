<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pendapatan_air extends CI_Model
{
    /**
     * Menghitung rencana pendapatan air per bulan (Jan s/d Des).
     *
     * Sumber data:
     *  - rkap_pelanggan  -> jumlah pelanggan akhir per bulan per jenis pelanggan (id_kd = 6)
     *  - rkap_pola_konsumsi -> konsumsi rata-rata (satu nilai per tahun, diestimasi dari rata-rata Jan-Jun)
     *  - rkap_tarif_rata -> tarif rata-rata (satu nilai per tahun)
     *  - rkap_jasa_tambahan -> jasa pemeliharaan & administrasi per SR per bulan
     *
     * Metode perhitungan:
     *  - Konsumsi efektif per bulan = konsumsi_rata x (jumlah_hari_tagihan / rata_rata_hari_setahun)
     *    dengan jumlah_hari_tagihan mengikuti konsep pembacaan arrears (bulan M memakai hari bulan M-1),
     *    sehingga pemakaian berfluktuasi mengikuti pola tagihan realisasi.
     *  - Penjualan Air  = pelanggan x konsumsi_efektif x tarif
     *  - Jasa Pemeliharaan & Administrasi = pelanggan x tarif jasa (biaya tetap per SR/bulan, TIDAK ikut jumlah hari)
     *  - Tagihan Air = Penjualan Air + Jasa Pemeliharaan + Jasa Administrasi
     *
     * Catatan: untuk konsistensi dengan nilai rata-rata, basis hari memakai rata-rata setahun
     * (365/12 atau 366/12), sehingga total setahun = estimasi awal, hanya distribusi bulanannya yang berubah.
     *
     * @param int  $tahun Tahun anggaran
     * @param int  $upk   ID UPK (kosong = konsolidasi semua UPK)
     * @return array ['nama_upk'=>string, 'data'=>per jenis pelanggan, 'total'=>gabungan semua jenis]
     */
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

// Jumlah hari tagihan per bulan (konsep arrears: bulan M memakai hari bulan M-1)
        // + rata-rata hari per bulan (365/12 atau 366/12)
        $hari_bulan = $this->getHariTagihanPerBulan($tahun);
        $base_hari  = array_sum($hari_bulan) / 12;

        $nama_upk = !empty($rows) ? $rows[0]['nama_upk'] : '';

        // Struktur data per jenis pelanggan ("data")
        $data = [];

        // Akumulator sementara per jenis pelanggan per bulan:
        //  - pel  -> penjumlahan pelanggan akhir
        //  - pola_num  -> sigma(pelanggan x konsumsi_efektif) untuk rata-rata tertimbang
        //  - tarif_num -> sigma(pelanggan x tarif) untuk rata-rata tertimbang
        //  - penjualan -> sigma(pelanggan x konsumsi_efektif x tarif)
        //  - jasa_admin/jasa_pem -> sigma(pelanggan x jasa) [sudah dikalikan jumlah pelanggan]
        foreach ($rows as $r) {
            $jp = $r['nama_jp'] ?? 'LAINNYA';
            $bulan = (int)$r['bulan'];
            if ($bulan < 1 || $bulan > 12) $bulan = 1;

            if (!isset($data[$jp])) {
                $data[$jp] = [
                    'Pelanggan Akhir'   => array_fill(1, 12, 0),
                    'Pola Konsumsi'     => array_fill(1, 12, 0), // diisi rata-rata tertimbang pada tahap finalisasi
                    'Tarif Rata'        => array_fill(1, 12, 0), // diisi rata-rata tertimbang pada tahap finalisasi
                    'Penjualan Air'     => array_fill(1, 12, 0),
                    'Jasa Pemeliharaan' => array_fill(1, 12, 0),
                    'Jasa Administrasi' => array_fill(1, 12, 0),
                    'Tagihan Air'       => array_fill(1, 12, 0),
                    // akumulator internal (tidak dikembalikan ke pemanggil)
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

            // Konsumsi efektif disesuaikan jumlah hari bulan (berfluktuasi 31/28/30...).
            // Faktor = hari_bulan / base_hari; ~1,03 utk bulan 31 hari, ~0,92 utk Februari 28 hari, dst.
            $pola_efektif = $pola * ($hari_bulan[$bulan] / $base_hari);

            // Nilai per baris: jasa harus dikali jumlah pelanggan (biaya per SR)
            $penjualan_row = $pel * $pola_efektif * $tarif;
            $jasa_pem_amount = $pel * $jp_jasa_pem;
            $jasa_adm_amount = $pel * $jp_jasa_adm;

            // Timpa akumulator dengan nilai baris ini
            $data[$jp]['_acc']['pel'][$bulan] += $pel;
            $data[$jp]['_acc']['pola_num'][$bulan] += $pel * $pola_efektif;
            $data[$jp]['_acc']['tarif_num'][$bulan] += $pel * $tarif;
            $data[$jp]['_acc']['penjualan'][$bulan] += $penjualan_row;
            $data[$jp]['_acc']['jasa_admin'][$bulan] += $jasa_adm_amount;
            $data[$jp]['_acc']['jasa_pem'][$bulan] += $jasa_pem_amount;
        }

// Hitung rata-rata tertimbang & total per jenis pelanggan per bulan
        // $total menampung gabungan semua jenis pelanggan (untuk baris "Jumlah" di tabel)
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

                // Pelanggan Akhir = jumlah pelanggan pada bulan tsb
                $block['Pelanggan Akhir'][$m] = (int) $pel_sum;

                // Pola Konsumsi = rata-rata tertimbang: sigma(pel x konsumsi_efektif) / sigma(pel)
                $block['Pola Konsumsi'][$m] = $pel_sum > 0 ? ($block['_acc']['pola_num'][$m] / $pel_sum) : 0;

                // Tarif Rata = rata-rata tertimbang: sigma(pel x tarif) / sigma(pel)
                $block['Tarif Rata'][$m] = $pel_sum > 0 ? ($block['_acc']['tarif_num'][$m] / $pel_sum) : 0;

                // Penjualan Air = total keseluruhan
                $block['Penjualan Air'][$m] = $block['_acc']['penjualan'][$m];

                // Jasa (total, sudah dikalikan pelanggan)
                $block['Jasa Pemeliharaan'][$m] = $block['_acc']['jasa_pem'][$m];
                $block['Jasa Administrasi'][$m] = $block['_acc']['jasa_admin'][$m];

                // Tagihan Air = penjualan + jasa
                $block['Tagihan Air'][$m] = $block['Penjualan Air'][$m] + $block['Jasa Pemeliharaan'][$m] + $block['Jasa Administrasi'][$m];

                // === Akumulasi ke TOTAL (gabungan semua jenis pelanggan) ===
                $total['Pelanggan Akhir'][$m]   += $block['Pelanggan Akhir'][$m];
                $total['Pola Konsumsi'][$m]     += $block['Pola Konsumsi'][$m] * $block['Pelanggan Akhir'][$m]; // sementara dikali bobot pelanggan
                $total['Tarif Rata'][$m]        += $block['Tarif Rata'][$m] * $block['Pelanggan Akhir'][$m];   // sementara dikali bobot pelanggan
                $total['Penjualan Air'][$m]     += $block['Penjualan Air'][$m];
                $total['Jasa Pemeliharaan'][$m] += $block['Jasa Pemeliharaan'][$m];
                $total['Jasa Administrasi'][$m] += $block['Jasa Administrasi'][$m];
                $total['Tagihan Air'][$m]       += $block['Tagihan Air'][$m];
            }
            // Hapus akumulator internal agar hasil akhir tetap bersih
            unset($block['_acc']);
        }

        // Selesaikan rata-rata tertimbang untuk TOTAL (bagi dengan jumlah pelanggan gabungan)
        for ($m = 1; $m <= 12; $m++) {
            $pel_sum = $total['Pelanggan Akhir'][$m];
            if ($pel_sum > 0) {
                $total['Pola Konsumsi'][$m] = $total['Pola Konsumsi'][$m] / $pel_sum;
                $total['Tarif Rata'][$m]    = $total['Tarif Rata'][$m] / $pel_sum;
            }
        }
        unset($r, $rows);

        return [
            'nama_upk' => $nama_upk,
            'data'     => $data,
            'total'    => $total
        ];
    }

    /**
     * Menghitung jumlah hari setiap bulan pada tahun tertentu.
     * Dipakai untuk menyesuaikan konsumsi air agar berfluktuasi sesuai 31/28/29/30 hari.
     *
     * @param int $tahun Tahun anggaran
     * @return array Index 1..12 berisi jumlah hari tiap bulan (Februari otomatis 28/29 utk kabisat)
     */
    private function getJumlahHariPerBulan($tahun)
    {
        $hari = [];
        for ($m = 1; $m <= 12; $m++) {
            $hari[$m] = cal_days_in_month(CAL_GREGORIAN, $m, $tahun);
        }
        return $hari;
    }

    /**
     * Jumlah hari yang dipakai utk tagihan tiap bulan (konsep pembacaan arrears/belakang).
     *
     * Pendapatan bulan M berasal dari pembacaan bulan M-1 (pemakaian periode sebelumnya),
     * jadi jumlah hari yang dipakai = jumlah hari BULAN SEBELUMNYA:
     *  - Tagihan Januari  memakai Desember tahun sebelumnya (selalu 31 hari).
     *  - Tagihan Februari memakai Januari (31), Maret memakai Februari (28/29), dst.
     *
     * @param int $tahun Tahun anggaran
     * @return array Index 1..12 = jumlah hari utk tagihan bulan tsb
     */
    private function getHariTagihanPerBulan($tahun)
    {
        $hari = $this->getJumlahHariPerBulan($tahun);

        $tagihan = [1 => 31]; // Januari selalu memakai Desember tahun sebelumnya (31 hari)
        for ($m = 2; $m <= 12; $m++) {
            $tagihan[$m] = $hari[$m - 1];
        }
        return $tagihan;
    }

    /**
     * Pemetaan kode perkiraan (no_per) pembukuan air per UPK.
     * Setiap UPK punya 3 kode: penjualan air, jasa pemeliharaan, jasa administrasi.
     *
     * @param int $id_upk ID UPK
     * @return array|null ['penjualan'=>..., 'pemeliharaan'=>..., 'admin'=>...] atau null bila tidak dikenal
     */
    private function getKodePerkiraan($id_upk)
    {
        $mapping = [
            1  => ['penjualan' => '81.01.01.01', 'pemeliharaan' => '81.01.02.01', 'admin' => '81.01.03.01'], // Bondowoso
            2  => ['penjualan' => '81.01.01.02', 'pemeliharaan' => '81.01.02.02', 'admin' => '81.01.03.02'], // Sukosari 1
            3  => ['penjualan' => '81.01.01.03', 'pemeliharaan' => '81.01.02.03', 'admin' => '81.01.03.03'], // Maesan
            4  => ['penjualan' => '81.01.01.04', 'pemeliharaan' => '81.01.02.04', 'admin' => '81.01.03.04'], // Tegalampel
            5  => ['penjualan' => '81.01.01.05', 'pemeliharaan' => '81.01.02.05', 'admin' => '81.01.03.05'], // Tapen
            6  => ['penjualan' => '81.01.01.06', 'pemeliharaan' => '81.01.02.06', 'admin' => '81.01.03.06'], // Prajekan
            7  => ['penjualan' => '81.01.01.07', 'pemeliharaan' => '81.01.02.07', 'admin' => '81.01.03.07'], // Tlogosari
            8  => ['penjualan' => '81.01.01.08', 'pemeliharaan' => '81.01.02.08', 'admin' => '81.01.03.08'], // Wringin
            9  => ['penjualan' => '81.01.01.09', 'pemeliharaan' => '81.01.02.09', 'admin' => '81.01.03.09'], // Curahdami
            10 => ['penjualan' => '81.01.01.10', 'pemeliharaan' => '81.01.02.10', 'admin' => '81.01.03.10'], // Tamanan
            11 => ['penjualan' => '81.01.01.11', 'pemeliharaan' => '81.01.02.11', 'admin' => '81.01.03.11'], // Tenggarang
            12 => ['penjualan' => '81.01.01.12', 'pemeliharaan' => '81.01.02.12', 'admin' => '81.01.03.12'], // Tamankrocok
            13 => ['penjualan' => '81.01.01.13', 'pemeliharaan' => '81.01.02.13', 'admin' => '81.01.03.13'], // Wonosari
            14 => ['penjualan' => '81.01.01.14', 'pemeliharaan' => '81.01.02.14', 'admin' => '81.01.03.14'], // Klabang
            15 => ['penjualan' => '81.01.01.15', 'pemeliharaan' => '81.01.02.15', 'admin' => '81.01.03.15'], // Sukosari 2
        ];

        return $mapping[$id_upk] ?? null;
    }

    /**
     * Menyalin hasil perhitungan pendapatan air (penjualan, jasa pemeliharaan, jasa admin)
     * dari suatu UPK ke tabel rkap_rekap, per bulan Jan s/d Des.
     *
     * @param int $tahun Tahun anggaran
     * @param int $upk   ID UPK
     * @return bool true bila berhasil, false bila UPK/kode perkiraan tidak dikenal
     */
    public function insertRekapPendapatanAir($tahun, $upk)
    {
        // Ikutkan semua UPK: ambil hasil perhitungan lalu gunakan bagian 'total'
        $result = $this->getDataPendapatanAir($tahun, $upk);
        $data   = $result['total'];

        $upkRow = $this->db->get_where('rkap_nama_upk', ['id_upk' => $upk])->row();
        if (!$upkRow) return false;

        $cabang_id = $upkRow->kode;

        // Ambil kode perkiraan (no_per) sesuai id_upk
        $kode = $this->getKodePerkiraan($upk);
        if (!$kode) return false;

        // Loop bulan Januari s/d Desember
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            // Hapus data rekap lama dulu agar tidak dobel (khusus 3 kode air tsb)
            $this->db->where('id_upk', $upk);
            $this->db->where('bulan', sprintf('%04d-%02d-01', $tahun, $bulan));
            $this->db->where_in('no_per_id', [$kode['penjualan'], $kode['pemeliharaan'], $kode['admin']]);
            $this->db->delete('rkap_rekap');

            // 1) Insert penjualan air
            $this->db->insert('rkap_rekap', [
                'id_upk'    => $upk,
                'cabang_id' => $cabang_id,
                'no_per_id' => $kode['penjualan'],
                'bulan'     => sprintf('%04d-%02d-01', $tahun, $bulan),
                'pagu'      => $data['Penjualan Air'][$bulan], // sudah mengandung penyesuaian jumlah hari
            ]);

            // 2) Insert jasa pemeliharaan
            $this->db->insert('rkap_rekap', [
                'id_upk'    => $upk,
                'cabang_id' => $cabang_id,
                'no_per_id' => $kode['pemeliharaan'],
                'bulan'     => sprintf('%04d-%02d-01', $tahun, $bulan),
                'pagu'      => $data['Jasa Pemeliharaan'][$bulan],
            ]);

            // 3) Insert jasa administrasi
            $this->db->insert('rkap_rekap', [
                'id_upk'    => $upk,
                'cabang_id' => $cabang_id,
                'no_per_id' => $kode['admin'],
                'bulan'     => sprintf('%04d-%02d-01', $tahun, $bulan),
                'pagu'      => $data['Jasa Administrasi'][$bulan],
            ]);
        }

        return true;
    }

    /**
     * Ambil data tangki air per UPK pada tahun tertentu (seluruh bulan).
     *
     * @param int|null $upk   ID UPK (kosong = semua UPK)
     * @param int      $tahun Tahun anggaran
     * @return array Baris tabel rkap_tangki_air
     */
    public function getTangkiAir($upk, $tahun)
    {
        $this->db->from('rkap_tangki_air');

        if ($upk) {
            $this->db->where('id_upk', $upk);
        }

        $this->db->where('tahun', $tahun);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Ambil data tangki air per kode perkiraan (no_per) + tahun, diindeks per bulan.
     *
     * @param string $no_per_id Kode perkiraan tangki air
     * @param int    $tahun     Tahun anggaran
     * @return array Index bulan (1..12) => baris rkap_tangki_air
     */
    public function getTangkiAirByNoPer($no_per_id, $tahun)
    {
        $this->db->from('rkap_tangki_air');
        $this->db->where('no_per_id', $no_per_id);
        $this->db->where('tahun', $tahun);
        $query = $this->db->get();
        $result = [];
        foreach ($query->result() as $row) {
            $result[(int)$row->bulan] = $row;
        }
        return $result;
    }

    /**
     * Simpan (insert atau update) satu baris data tangki air per cabang/tahun/bulan.
     *
     * @param array $data Data baris rkap_tangki_air
     * @return bool
     */
    public function save_tangki_air($data)
    {
        $this->db->where('cabang_id', $data['cabang_id']);
        $this->db->where('tahun', $data['tahun']);
        $this->db->where('bulan', $data['bulan']);
        $query = $this->db->get('rkap_tangki_air');

        if ($query->num_rows() > 0) {
            $this->db->where('cabang_id', $data['cabang_id']);
            $this->db->where('tahun', $data['tahun']);
            $this->db->where('bulan', $data['bulan']);
            return $this->db->update('rkap_tangki_air', $data);
        } else {
            return $this->db->insert('rkap_tangki_air', $data);
        }
    }

    public function save_rekap_tangki($data)
    {
        // Cek apakah data rekap sudah ada
        $this->db->where('id_upk', $data['id_upk']);
        $this->db->where('cabang_id', $data['cabang_id']);
        $this->db->where('bulan', $data['bulan']);
        $query = $this->db->get('rkap_rekap');

        if ($query->num_rows() > 0) {
            // Jika sudah ada, lakukan update
            $this->db->where('id_upk', $data['id_upk']);
            $this->db->where('cabang_id', $data['cabang_id']);
            $this->db->where('bulan', $data['bulan']);
            return $this->db->update('rkap_rekap', [
                'no_per_id' => $data['no_per_id'],
                'pagu'      => $data['pagu']
            ]);
        } else {
            // Jika belum ada, insert baru
            return $this->db->insert('rkap_rekap', $data);
        }
    }
}
