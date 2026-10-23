<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_jurnal_rkap extends CI_Model
{
    public function getHeader($tahun)
    {
        $header = $this->db->where('tahun', (int)$tahun)->get('jurnal_rkap')->row();
        if ($header) return $header;
        return (object)[
            'id' => 0,
            'tahun' => (int)$tahun,
            'no_jurnal' => 'JRN-01',
            'tanggal' => $tahun . '-12-31',
            'uraian_header' => 'JURNAL RKAP TAHUN ' . $tahun,
        ];
    }

    public function getDetails($tahun)
    {
        $header = $this->getHeader($tahun);
        if ($header->id) {
            $rows = $this->db->where('jurnal_id', $header->id)->order_by('no_urutan', 'ASC')->get('jurnal_rkap_detail')->result();
            if ($rows) return $rows;
        }
        return $this->getTemplateRows();
    }

    public function getTemplateRows()
    {
        $rows = [
            ['kelompok'=>'JRA','uraian'=>'Piutang Rekening Air','kode_akun'=>'13.01','posisi_kode'=>'13','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JRA','uraian'=>'Pendapatan Penjualan Air','kode_akun'=>'81.01','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JRNA','uraian'=>'Kas','kode_akun'=>'11.01','posisi_kode'=>'11','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JRNA','uraian'=>'Pendapatan Sambungan Baru','kode_akun'=>'81.02.01','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JRNA','uraian'=>'Pendapatan Pendaftaran','kode_akun'=>'81.02.02','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JRNA','uraian'=>'Pendapatan Balik Nama','kode_akun'=>'81.02.03','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JRNA','uraian'=>'Pendapatan Penyambungan Kembali','kode_akun'=>'81.02.04','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JRNA','uraian'=>'Pendapatan Denda','kode_akun'=>'81.02.05','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JRNA','uraian'=>'Pendapatan Ganti Meter Rusak','kode_akun'=>'81.02.06','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JPK','uraian'=>'Kas','kode_akun'=>'11.01','posisi_kode'=>'11','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JPK','uraian'=>'Piutang Rekening Air','kode_akun'=>'13.01','posisi_kode'=>'13','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JPK','uraian'=>'Pendapatan Bunga dan Jasa Giro','kode_akun'=>'88.01.10','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JPK','uraian'=>'Penjualan Barang Bekas','kode_akun'=>'88.99','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JPK','uraian'=>'Pendapatan AMDK','kode_akun'=>'88.02','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JPK','uraian'=>'Pendapatan Truk Tangki','kode_akun'=>'81.03.30','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JPK','uraian'=>'Pendapatan Subsidi','kode_akun'=>'81.03.40','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JPK','uraian'=>'Pendapatan Jasa IT','kode_akun'=>'81.03.50','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JPBIK','uraian'=>'Beban Operasi Lainnya','kode_akun'=>'96.99','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JPBIK','uraian'=>'Beban Pemeliharaan','kode_akun'=>'96.99','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JPBIK','uraian'=>'Beban Pemakaian Bahan Kimia','kode_akun'=>'91.99','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JPBIK','uraian'=>'Beban Instalasi Transmisi Distribusi','kode_akun'=>'93.99','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JPBIK','uraian'=>'Persediaan','kode_akun'=>'15','posisi_kode'=>'15','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'Persediaan','kode_akun'=>'15','posisi_kode'=>'15','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'Tanah','kode_akun'=>'31.01','posisi_kode'=>'31','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'Instalasi Sumber','kode_akun'=>'31.02','posisi_kode'=>'31','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'Instalasi Pompa','kode_akun'=>'31.03','posisi_kode'=>'31','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'Instalasi Transmisi Distribusi','kode_akun'=>'31.05','posisi_kode'=>'31','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'Bangunan/Gedung','kode_akun'=>'31.06','posisi_kode'=>'31','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'Peralatan dan Perlengkapan','kode_akun'=>'31.07','posisi_kode'=>'31','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'Kendaraan','kode_akun'=>'31.08','posisi_kode'=>'31','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'Inventaris','kode_akun'=>'31.09','posisi_kode'=>'31','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'Investasi Lain-lain','kode_akun'=>'40','posisi_kode'=>'40','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'Beban Pajak','kode_akun'=>'97','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'Pengeluaran AMDK','kode_akun'=>'98.02','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'Hutang Pihak Luar','kode_akun'=>'50.05','posisi_kode'=>'50.05','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'Beban Pegawai','kode_akun'=>'96.99','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'Beban Pemakaian Bahan Bakar','kode_akun'=>'96.99','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'Beban Listrik','kode_akun'=>'96.99','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'Beban Pemakaian Bahan Pembantu','kode_akun'=>'96.99','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'Beban Operasi Lainnya','kode_akun'=>'96.99','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'Beban Pemeliharaan','kode_akun'=>'96.99','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'Pembelian Air Baku','kode_akun'=>'91.99','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'HPP','kode_akun'=>'95','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'DVHD','uraian'=>'Hutang yang Harus Dibayar','kode_akun'=>'50.01','posisi_kode'=>'50.01','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JBK','uraian'=>'Hutang yang Harus Dibayar','kode_akun'=>'50.01','posisi_kode'=>'50.01','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JBK','uraian'=>'Kas','kode_akun'=>'11.01','posisi_kode'=>'11','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JU','uraian'=>'Biaya Penyusutan','kode_akun'=>'91.09','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JU','uraian'=>'Biaya Penyisihan Piutang','kode_akun'=>'96.07','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JU','uraian'=>'Biaya Umum','kode_akun'=>'96','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JU','uraian'=>'Biaya Penyusutan AMDK','kode_akun'=>'98.02.90','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JU','uraian'=>'Biaya Bank','kode_akun'=>'98.01','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JU','uraian'=>'Biaya Pajak','kode_akun'=>'97','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JU','uraian'=>'Jaspro','kode_akun'=>'96.01.05','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JU','uraian'=>'Kerugian Penjualan Barang Bekas','kode_akun'=>'99','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JU','uraian'=>'Kerugian Luar Biasa','kode_akun'=>'99','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JU','uraian'=>'Hutang','kode_akun'=>'50.01.01','posisi_kode'=>'50.01','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JU','uraian'=>'Pembelian Aktiva Lancar Lainnya','kode_akun'=>'50.05.04','posisi_kode'=>'50.05','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JU','uraian'=>'Laba yang Belum Dibayar','kode_akun'=>'99','posisi_kode'=>'','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JU','uraian'=>'Akumulasi Penyusutan','kode_akun'=>'31.1','posisi_kode'=>'31.1','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JU','uraian'=>'Penyisihan Piutang','kode_akun'=>'13.06','posisi_kode'=>'13.06','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JU','uraian'=>'Kas','kode_akun'=>'11.01','posisi_kode'=>'11','debit'=>0,'kredit'=>0,'keterangan'=>''],
            ['kelompok'=>'JU','uraian'=>'Hutang Pajak','kode_akun'=>'50','posisi_kode'=>'50.05','debit'=>0,'kredit'=>0,'keterangan'=>''],
        ];
        return array_map(function ($row) { return (object)$row; }, $rows);
    }

    public function getTotalsByYear($tahun)
    {
        $this->db->select('d.posisi_kode, SUM(d.debit) AS debit, SUM(d.kredit) AS kredit');
        $this->db->from('jurnal_rkap_detail d');
        $this->db->join('jurnal_rkap j', 'd.jurnal_id = j.id');
        $this->db->where('j.tahun', (int)$tahun);
        $this->db->where('d.posisi_kode !=', '');
        $this->db->group_by('d.posisi_kode');
        $rows = $this->db->get()->result();
        $result = [];
        foreach ($rows as $row) {
            $result[$row->posisi_kode] = ['debit'=>(float)$row->debit, 'kredit'=>(float)$row->kredit];
        }
        return $result;
    }

    public function getSummary($tahun)
    {
        $this->db->select('COALESCE(SUM(d.debit),0) AS debit, COALESCE(SUM(d.kredit),0) AS kredit');
        $this->db->from('jurnal_rkap_detail d');
        $this->db->join('jurnal_rkap j', 'd.jurnal_id = j.id');
        $this->db->where('j.tahun', (int)$tahun);
        return $this->db->get()->row() ?: (object)['debit'=>0, 'kredit'=>0];
    }

    private function normalizeNumber($value)
    {
        $value = trim((string)($value ?? ''));
        if ($value === '') return 0;
        $value = str_replace(' ', '', $value);
        if (strpos($value, ',') !== false) {
            $value = str_replace(',', '.', str_replace('.', '', $value));
        } elseif (preg_match('/^-?\d{1,3}(\.\d{3})+$/', $value)) {
            $value = str_replace('.', '', $value);
        }
        return is_numeric($value) ? (float)$value : 0;
    }

    private function positionCode($accountCode)
    {
        $accountCode = trim((string)$accountCode);
        $rules = [
            '11.01'=> '11', '11.02'=>'11', '11.03'=>'11', '11.04'=>'11',
            '12.01'=>'12', '13.01'=>'13', '31.01'=>'31', '31.02'=>'31', '31.03'=>'31', '31.05'=>'31', '31.06'=>'31', '31.07'=>'31', '31.08'=>'31', '31.09'=>'31',
            '31.10'=>'31.1', '31.1'=>'31.1', '14.1'=>'14.1', '42.01'=>'42.01', '42.02'=>'42.02', '42.03'=>'42.03', '42.04'=>'42.04', '42.05'=>'42.05', '42.06'=>'42.06',
            '50.01.01'=>'50.01', '50.05.04'=>'50.05', '70.09'=>'70.09',
        ];
        if (isset($rules[$accountCode])) return $rules[$accountCode];
        if (preg_match('/^31\./', $accountCode)) return '31';
        if (preg_match('/^50\.01/', $accountCode)) return '50.01';
        if (preg_match('/^50\.05/', $accountCode)) return '50.05';
        if (preg_match('/^13\.06/', $accountCode)) return '13.06';
        if (preg_match('/^42\.0[1-6]/', $accountCode)) return $accountCode;
        if (preg_match('/^70\.0[1-9]/', $accountCode)) return $accountCode;
        return '';
    }

    public function saveJournal($tahun, $headerData, $lines, $updatedBy)
    {
        $this->db->trans_start();
        $header = $this->db->where('tahun', (int)$tahun)->get('jurnal_rkap')->row();
        $headerRow = [
            'tahun'=>(int)$tahun,
            'no_jurnal'=>trim($headerData['no_jurnal'] ?? 'JRN-01') ?: 'JRN-01',
            'tanggal'=>$headerData['tanggal'] ?? ($tahun . '-12-31'),
            'uraian_header'=>trim($headerData['uraian_header'] ?? ('JURNAL RKAP TAHUN ' . $tahun)),
            'updated_by'=>$updatedBy,
        ];
        if ($header) {
            $this->db->where('id', $header->id)->update('jurnal_rkap', $headerRow);
            $jurnalId = $header->id;
            $this->db->where('jurnal_id', $jurnalId)->delete('jurnal_rkap_detail');
        } else {
            $headerRow['created_by'] = $updatedBy;
            $this->db->insert('jurnal_rkap', $headerRow);
            $jurnalId = $this->db->insert_id();
        }
        $noUrut = 1;
        foreach ($lines as $line) {
            $uraian = trim((string)($line['uraian'] ?? ''));
            $kode = trim((string)($line['kode_akun'] ?? ''));
            if ($uraian === '' && $kode === '') continue;
            $debit = $this->normalizeNumber($line['debit'] ?? 0);
            $kredit = $this->normalizeNumber($line['kredit'] ?? 0);
            $posisi = trim((string)($line['posisi_kode'] ?? ''));
            if ($posisi === '') $posisi = $this->positionCode($kode);
            $this->db->insert('jurnal_rkap_detail', [
                'jurnal_id'=>$jurnalId,
                'no_urutan'=>$noUrut++,
                'kelompok'=>trim((string)($line['kelompok'] ?? 'JU')) ?: 'JU',
                'uraian'=>$uraian,
                'kode_akun'=>$kode,
                'posisi_kode'=>$posisi,
                'debit'=>$debit,
                'kredit'=>$kredit,
                'keterangan'=>trim((string)($line['keterangan'] ?? '')),
                'updated_by'=>$updatedBy,
            ]);
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }

    public function cekBalance($lines)
    {
        if (!is_array($lines)) $lines = [];

        $masalahBaris = [];
        $subtotal = [];
        $urutan = [];

        foreach (array_values($lines) as $i => $line) {
            $no = $i + 1;
            $uraian = trim((string)($line['uraian'] ?? ''));
            $kode = trim((string)($line['kode_akun'] ?? ''));
            $kelompok = trim((string)($line['kelompok'] ?? 'JU')) ?: 'JU';
            $d = $this->normalizeNumber($line['debit'] ?? 0);
            $k = $this->normalizeNumber($line['kredit'] ?? 0);
            $kosong = ($uraian === '' && $kode === '');

            if ($kosong) {
                if ($d != 0 || $k != 0) {
                    $masalahBaris[] = ['no' => $no, 'pesan' => 'Uraian dan Kode Rekening kosong, baris ini tidak akan tersimpan.'];
                }
                continue;
            }
            if ($d < 0 || $k < 0) {
                $masalahBaris[] = ['no' => $no, 'pesan' => 'Nilai Debit/Kredit tidak boleh negatif.'];
                continue;
            }
            if ($d > 0 && $k > 0) {
                $masalahBaris[] = ['no' => $no, 'pesan' => 'Debit dan Kredit tidak boleh diisi sekaligus.'];
                continue;
            }

            if (!isset($subtotal[$kelompok])) {
                $subtotal[$kelompok] = ['debit' => 0, 'kredit' => 0];
                $urutan[] = $kelompok;
            }
            $subtotal[$kelompok]['debit'] += $d;
            $subtotal[$kelompok]['kredit'] += $k;
        }

        $kelompokMasalah = [];
        foreach ($urutan as $g) {
            $sel = $subtotal[$g]['debit'] - $subtotal[$g]['kredit'];
            if (abs($sel) >= 0.005) {
                $kelompokMasalah[] = [
                    'kelompok' => $g,
                    'debit' => $subtotal[$g]['debit'],
                    'kredit' => $subtotal[$g]['kredit'],
                    'selisih' => $sel,
                ];
            }
        }

        return [
            'subtotal' => $subtotal,
            'urutan' => $urutan,
            'baris' => $masalahBaris,
            'kelompok' => $kelompokMasalah,
            'seimbang' => empty($masalahBaris) && empty($kelompokMasalah),
        ];
    }
}
