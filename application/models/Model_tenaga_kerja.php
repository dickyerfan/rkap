<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_tenaga_kerja extends CI_Model
{
    public function get_naker($tahun, $upk = null)
    {
        // Buat filter UPK dinamis
        $filter_upk = "";
        if (!empty($upk)) {
            $filter_upk = " AND bagian = " . $this->db->escape($upk);
        }

        $query = $this->db->query("
        SELECT 
        id_tk
            id_pegawai,
            bagian,
            kategori,
            jabatan,
            nama,

            -- Gaji Pokok
            MAX(CASE WHEN MONTH(bulan)=1 THEN gaji_pokok END) AS jan_gaji,
            MAX(CASE WHEN MONTH(bulan)=2 THEN gaji_pokok END) AS feb_gaji,
            MAX(CASE WHEN MONTH(bulan)=3 THEN gaji_pokok END) AS mar_gaji,
            MAX(CASE WHEN MONTH(bulan)=4 THEN gaji_pokok END) AS apr_gaji,
            MAX(CASE WHEN MONTH(bulan)=5 THEN gaji_pokok END) AS mei_gaji,
            MAX(CASE WHEN MONTH(bulan)=6 THEN gaji_pokok END) AS jun_gaji,
            MAX(CASE WHEN MONTH(bulan)=7 THEN gaji_pokok END) AS jul_gaji,
            MAX(CASE WHEN MONTH(bulan)=8 THEN gaji_pokok END) AS agu_gaji,
            MAX(CASE WHEN MONTH(bulan)=9 THEN gaji_pokok END) AS sep_gaji,
            MAX(CASE WHEN MONTH(bulan)=10 THEN gaji_pokok END) AS okt_gaji,
            MAX(CASE WHEN MONTH(bulan)=11 THEN gaji_pokok END) AS nov_gaji,
            MAX(CASE WHEN MONTH(bulan)=12 THEN gaji_pokok END) AS des_gaji,

            -- Tunjangan Istri
            MAX(CASE WHEN MONTH(bulan)=1 THEN t_istri END) AS jan_istri,
            MAX(CASE WHEN MONTH(bulan)=2 THEN t_istri END) AS feb_istri,
            MAX(CASE WHEN MONTH(bulan)=3 THEN t_istri END) AS mar_istri,
            MAX(CASE WHEN MONTH(bulan)=4 THEN t_istri END) AS apr_istri,
            MAX(CASE WHEN MONTH(bulan)=5 THEN t_istri END) AS mei_istri,
            MAX(CASE WHEN MONTH(bulan)=6 THEN t_istri END) AS jun_istri,
            MAX(CASE WHEN MONTH(bulan)=7 THEN t_istri END) AS jul_istri,
            MAX(CASE WHEN MONTH(bulan)=8 THEN t_istri END) AS agu_istri,
            MAX(CASE WHEN MONTH(bulan)=9 THEN t_istri END) AS sep_istri,
            MAX(CASE WHEN MONTH(bulan)=10 THEN t_istri END) AS okt_istri,
            MAX(CASE WHEN MONTH(bulan)=11 THEN t_istri END) AS nov_istri,
            MAX(CASE WHEN MONTH(bulan)=12 THEN t_istri END) AS des_istri,

            -- Tunjangan Anak
            MAX(CASE WHEN MONTH(bulan)=1 THEN t_anak END) AS jan_anak,
            MAX(CASE WHEN MONTH(bulan)=2 THEN t_anak END) AS feb_anak,
            MAX(CASE WHEN MONTH(bulan)=3 THEN t_anak END) AS mar_anak,
            MAX(CASE WHEN MONTH(bulan)=4 THEN t_anak END) AS apr_anak,
            MAX(CASE WHEN MONTH(bulan)=5 THEN t_anak END) AS mei_anak,
            MAX(CASE WHEN MONTH(bulan)=6 THEN t_anak END) AS jun_anak,
            MAX(CASE WHEN MONTH(bulan)=7 THEN t_anak END) AS jul_anak,
            MAX(CASE WHEN MONTH(bulan)=8 THEN t_anak END) AS agu_anak,
            MAX(CASE WHEN MONTH(bulan)=9 THEN t_anak END) AS sep_anak,
            MAX(CASE WHEN MONTH(bulan)=10 THEN t_anak END) AS okt_anak,
            MAX(CASE WHEN MONTH(bulan)=11 THEN t_anak END) AS nov_anak,
            MAX(CASE WHEN MONTH(bulan)=12 THEN t_anak END) AS des_anak,

            -- Tunjangan Jabatan
            MAX(CASE WHEN MONTH(bulan)=1 THEN t_jabatan END) AS jan_jabatan,
            MAX(CASE WHEN MONTH(bulan)=2 THEN t_jabatan END) AS feb_jabatan,
            MAX(CASE WHEN MONTH(bulan)=3 THEN t_jabatan END) AS mar_jabatan,
            MAX(CASE WHEN MONTH(bulan)=4 THEN t_jabatan END) AS apr_jabatan,
            MAX(CASE WHEN MONTH(bulan)=5 THEN t_jabatan END) AS mei_jabatan,
            MAX(CASE WHEN MONTH(bulan)=6 THEN t_jabatan END) AS jun_jabatan,
            MAX(CASE WHEN MONTH(bulan)=7 THEN t_jabatan END) AS jul_jabatan,
            MAX(CASE WHEN MONTH(bulan)=8 THEN t_jabatan END) AS agu_jabatan,
            MAX(CASE WHEN MONTH(bulan)=9 THEN t_jabatan END) AS sep_jabatan,
            MAX(CASE WHEN MONTH(bulan)=10 THEN t_jabatan END) AS okt_jabatan,
            MAX(CASE WHEN MONTH(bulan)=11 THEN t_jabatan END) AS nov_jabatan,
            MAX(CASE WHEN MONTH(bulan)=12 THEN t_jabatan END) AS des_jabatan,

            -- Tunjangan Pangan
            MAX(CASE WHEN MONTH(bulan)=1 THEN t_pangan END) AS jan_pangan,
            MAX(CASE WHEN MONTH(bulan)=2 THEN t_pangan END) AS feb_pangan,
            MAX(CASE WHEN MONTH(bulan)=3 THEN t_pangan END) AS mar_pangan,
            MAX(CASE WHEN MONTH(bulan)=4 THEN t_pangan END) AS apr_pangan,
            MAX(CASE WHEN MONTH(bulan)=5 THEN t_pangan END) AS mei_pangan,
            MAX(CASE WHEN MONTH(bulan)=6 THEN t_pangan END) AS jun_pangan,
            MAX(CASE WHEN MONTH(bulan)=7 THEN t_pangan END) AS jul_pangan,
            MAX(CASE WHEN MONTH(bulan)=8 THEN t_pangan END) AS agu_pangan,
            MAX(CASE WHEN MONTH(bulan)=9 THEN t_pangan END) AS sep_pangan,
            MAX(CASE WHEN MONTH(bulan)=10 THEN t_pangan END) AS okt_pangan,
            MAX(CASE WHEN MONTH(bulan)=11 THEN t_pangan END) AS nov_pangan,
            MAX(CASE WHEN MONTH(bulan)=12 THEN t_pangan END) AS des_pangan,

            -- Tunjangan Transport
            MAX(CASE WHEN MONTH(bulan)=1 THEN t_transport END) AS jan_transport,
            MAX(CASE WHEN MONTH(bulan)=2 THEN t_transport END) AS feb_transport,
            MAX(CASE WHEN MONTH(bulan)=3 THEN t_transport END) AS mar_transport,
            MAX(CASE WHEN MONTH(bulan)=4 THEN t_transport END) AS apr_transport,
            MAX(CASE WHEN MONTH(bulan)=5 THEN t_transport END) AS mei_transport,
            MAX(CASE WHEN MONTH(bulan)=6 THEN t_transport END) AS jun_transport,
            MAX(CASE WHEN MONTH(bulan)=7 THEN t_transport END) AS jul_transport,
            MAX(CASE WHEN MONTH(bulan)=8 THEN t_transport END) AS agu_transport,
            MAX(CASE WHEN MONTH(bulan)=9 THEN t_transport END) AS sep_transport,
            MAX(CASE WHEN MONTH(bulan)=10 THEN t_transport END) AS okt_transport,
            MAX(CASE WHEN MONTH(bulan)=11 THEN t_transport END) AS nov_transport,
            MAX(CASE WHEN MONTH(bulan)=12 THEN t_transport END) AS des_transport,

            -- Uang Makan
            MAX(CASE WHEN MONTH(bulan)=1 THEN uang_makan END) AS jan_makan,
            MAX(CASE WHEN MONTH(bulan)=2 THEN uang_makan END) AS feb_makan,
            MAX(CASE WHEN MONTH(bulan)=3 THEN uang_makan END) AS mar_makan,
            MAX(CASE WHEN MONTH(bulan)=4 THEN uang_makan END) AS apr_makan,
            MAX(CASE WHEN MONTH(bulan)=5 THEN uang_makan END) AS mei_makan,
            MAX(CASE WHEN MONTH(bulan)=6 THEN uang_makan END) AS jun_makan,
            MAX(CASE WHEN MONTH(bulan)=7 THEN uang_makan END) AS jul_makan,
            MAX(CASE WHEN MONTH(bulan)=8 THEN uang_makan END) AS agu_makan,
            MAX(CASE WHEN MONTH(bulan)=9 THEN uang_makan END) AS sep_makan,
            MAX(CASE WHEN MONTH(bulan)=10 THEN uang_makan END) AS okt_makan,
            MAX(CASE WHEN MONTH(bulan)=11 THEN uang_makan END) AS nov_makan,
            MAX(CASE WHEN MONTH(bulan)=12 THEN uang_makan END) AS des_makan,

            -- Tunjangan Perumahan
            MAX(CASE WHEN MONTH(bulan)=1 THEN t_perumahan END) AS jan_perumahan,
            MAX(CASE WHEN MONTH(bulan)=2 THEN t_perumahan END) AS feb_perumahan,
            MAX(CASE WHEN MONTH(bulan)=3 THEN t_perumahan END) AS mar_perumahan,
            MAX(CASE WHEN MONTH(bulan)=4 THEN t_perumahan END) AS apr_perumahan,
            MAX(CASE WHEN MONTH(bulan)=5 THEN t_perumahan END) AS mei_perumahan,
            MAX(CASE WHEN MONTH(bulan)=6 THEN t_perumahan END) AS jun_perumahan,
            MAX(CASE WHEN MONTH(bulan)=7 THEN t_perumahan END) AS jul_perumahan,
            MAX(CASE WHEN MONTH(bulan)=8 THEN t_perumahan END) AS agu_perumahan,
            MAX(CASE WHEN MONTH(bulan)=9 THEN t_perumahan END) AS sep_perumahan,
            MAX(CASE WHEN MONTH(bulan)=10 THEN t_perumahan END) AS okt_perumahan,
            MAX(CASE WHEN MONTH(bulan)=11 THEN t_perumahan END) AS nov_perumahan,
            MAX(CASE WHEN MONTH(bulan)=12 THEN t_perumahan END) AS des_perumahan,

            -- BPJS Kesehatan
            MAX(CASE WHEN MONTH(bulan)=1 THEN bpjs_kesehatan END) AS jan_bpjs_kes,
            MAX(CASE WHEN MONTH(bulan)=2 THEN bpjs_kesehatan END) AS feb_bpjs_kes,
            MAX(CASE WHEN MONTH(bulan)=3 THEN bpjs_kesehatan END) AS mar_bpjs_kes,
            MAX(CASE WHEN MONTH(bulan)=4 THEN bpjs_kesehatan END) AS apr_bpjs_kes,
            MAX(CASE WHEN MONTH(bulan)=5 THEN bpjs_kesehatan END) AS mei_bpjs_kes,
            MAX(CASE WHEN MONTH(bulan)=6 THEN bpjs_kesehatan END) AS jun_bpjs_kes,
            MAX(CASE WHEN MONTH(bulan)=7 THEN bpjs_kesehatan END) AS jul_bpjs_kes,
            MAX(CASE WHEN MONTH(bulan)=8 THEN bpjs_kesehatan END) AS agu_bpjs_kes,
            MAX(CASE WHEN MONTH(bulan)=9 THEN bpjs_kesehatan END) AS sep_bpjs_kes,
            MAX(CASE WHEN MONTH(bulan)=10 THEN bpjs_kesehatan END) AS okt_bpjs_kes,
            MAX(CASE WHEN MONTH(bulan)=11 THEN bpjs_kesehatan END) AS nov_bpjs_kes,
            MAX(CASE WHEN MONTH(bulan)=12 THEN bpjs_kesehatan END) AS des_bpjs_kes,

            -- BPJS TK
            MAX(CASE WHEN MONTH(bulan)=1 THEN bpjs_tk END) AS jan_bpjs_tk,
            MAX(CASE WHEN MONTH(bulan)=2 THEN bpjs_tk END) AS feb_bpjs_tk,
            MAX(CASE WHEN MONTH(bulan)=3 THEN bpjs_tk END) AS mar_bpjs_tk,
            MAX(CASE WHEN MONTH(bulan)=4 THEN bpjs_tk END) AS apr_bpjs_tk,
            MAX(CASE WHEN MONTH(bulan)=5 THEN bpjs_tk END) AS mei_bpjs_tk,
            MAX(CASE WHEN MONTH(bulan)=6 THEN bpjs_tk END) AS jun_bpjs_tk,
            MAX(CASE WHEN MONTH(bulan)=7 THEN bpjs_tk END) AS jul_bpjs_tk,
            MAX(CASE WHEN MONTH(bulan)=8 THEN bpjs_tk END) AS agu_bpjs_tk,
            MAX(CASE WHEN MONTH(bulan)=9 THEN bpjs_tk END) AS sep_bpjs_tk,
            MAX(CASE WHEN MONTH(bulan)=10 THEN bpjs_tk END) AS okt_bpjs_tk,
            MAX(CASE WHEN MONTH(bulan)=11 THEN bpjs_tk END) AS nov_bpjs_tk,
            MAX(CASE WHEN MONTH(bulan)=12 THEN bpjs_tk END) AS des_bpjs_tk,

            -- Dapenmapamsi
            MAX(CASE WHEN MONTH(bulan)=1 THEN dapenmapamsi END) AS jan_dapen,
            MAX(CASE WHEN MONTH(bulan)=2 THEN dapenmapamsi END) AS feb_dapen,
            MAX(CASE WHEN MONTH(bulan)=3 THEN dapenmapamsi END) AS mar_dapen,
            MAX(CASE WHEN MONTH(bulan)=4 THEN dapenmapamsi END) AS apr_dapen,
            MAX(CASE WHEN MONTH(bulan)=5 THEN dapenmapamsi END) AS mei_dapen,
            MAX(CASE WHEN MONTH(bulan)=6 THEN dapenmapamsi END) AS jun_dapen,
            MAX(CASE WHEN MONTH(bulan)=7 THEN dapenmapamsi END) AS jul_dapen,
            MAX(CASE WHEN MONTH(bulan)=8 THEN dapenmapamsi END) AS agu_dapen,
            MAX(CASE WHEN MONTH(bulan)=9 THEN dapenmapamsi END) AS sep_dapen,
            MAX(CASE WHEN MONTH(bulan)=10 THEN dapenmapamsi END) AS okt_dapen,
            MAX(CASE WHEN MONTH(bulan)=11 THEN dapenmapamsi END) AS nov_dapen,
            MAX(CASE WHEN MONTH(bulan)=12 THEN dapenmapamsi END) AS des_dapen,

            -- Total Gaji per Tahun
            MAX(CASE WHEN MONTH(bulan)=1 THEN total_gaji END) AS jan_t_gaji,
            MAX(CASE WHEN MONTH(bulan)=2 THEN total_gaji END) AS feb_t_gaji,
            MAX(CASE WHEN MONTH(bulan)=3 THEN total_gaji END) AS mar_t_gaji,
            MAX(CASE WHEN MONTH(bulan)=4 THEN total_gaji END) AS apr_t_gaji,
            MAX(CASE WHEN MONTH(bulan)=5 THEN total_gaji END) AS mei_t_gaji,
            MAX(CASE WHEN MONTH(bulan)=6 THEN total_gaji END) AS jun_t_gaji,
            MAX(CASE WHEN MONTH(bulan)=7 THEN total_gaji END) AS jul_t_gaji,
            MAX(CASE WHEN MONTH(bulan)=8 THEN total_gaji END) AS agu_t_gaji,
            MAX(CASE WHEN MONTH(bulan)=9 THEN total_gaji END) AS sep_t_gaji,
            MAX(CASE WHEN MONTH(bulan)=10 THEN total_gaji END) AS okt_t_gaji,
            MAX(CASE WHEN MONTH(bulan)=11 THEN total_gaji END) AS nov_t_gaji,
            MAX(CASE WHEN MONTH(bulan)=12 THEN total_gaji END) AS des_t_gaji,
            SUM(total_gaji) AS total_tahun

        FROM rkap_tenaga_kerja
        WHERE YEAR(bulan) = ? $filter_upk
        GROUP BY nama, jabatan, bagian, id_pegawai, kategori
        ORDER BY bagian, jabatan
    ", [$tahun]);

        return $query->result();
    }


    // kode lama
    // public function get_naker($tahun, $upk = null)
    // {
    //     $this->db->select("
    //     tk.id_tk,
    //     tk.nama AS nama,
    //     tk.jabatan,
    //     tk.bagian,
    //     tk.kategori,
    //     MAX(tk.gaji_pokok) AS gaji_pokok, 
    //     MAX(tk.t_istri) AS t_istri, 
    //     MAX(tk.t_anak) AS t_anak, 
    //     MAX(tk.t_jabatan) AS t_jabatan, 
    //     MAX(tk.t_transport) AS t_transport,
    //     MAX(tk.t_pangan) AS t_pangan,
    //     MAX(tk.uang_makan) AS uang_makan,
    //     MAX(tk.t_perumahan) AS t_perumahan,
    //     MAX(tk.bpjs_kesehatan) AS bpjs_kesehatan,
    //     MAX(tk.bpjs_tk) AS bpjs_tk,
    //     MAX(tk.dapenmapamsi) AS dapenmapamsi,
    //     MAX(tk.total_gaji) AS total_gaji,
    //     SUM(CASE WHEN MONTH(tk.bulan)=1 THEN tk.total_gaji ELSE 0 END) AS jan,
    //     SUM(CASE WHEN MONTH(tk.bulan)=2 THEN tk.total_gaji ELSE 0 END) AS feb,
    //     SUM(CASE WHEN MONTH(tk.bulan)=3 THEN tk.total_gaji ELSE 0 END) AS mar,
    //     SUM(CASE WHEN MONTH(tk.bulan)=4 THEN tk.total_gaji ELSE 0 END) AS apr,
    //     SUM(CASE WHEN MONTH(tk.bulan)=5 THEN tk.total_gaji ELSE 0 END) AS mei,
    //     SUM(CASE WHEN MONTH(tk.bulan)=6 THEN tk.total_gaji ELSE 0 END) AS jun,
    //     SUM(CASE WHEN MONTH(tk.bulan)=7 THEN tk.total_gaji ELSE 0 END) AS jul,
    //     SUM(CASE WHEN MONTH(tk.bulan)=8 THEN tk.total_gaji ELSE 0 END) AS agu,
    //     SUM(CASE WHEN MONTH(tk.bulan)=9 THEN tk.total_gaji ELSE 0 END) AS sep,
    //     SUM(CASE WHEN MONTH(tk.bulan)=10 THEN tk.total_gaji ELSE 0 END) AS okt,
    //     SUM(CASE WHEN MONTH(tk.bulan)=11 THEN tk.total_gaji ELSE 0 END) AS nov,
    //     SUM(CASE WHEN MONTH(tk.bulan)=12 THEN tk.total_gaji ELSE 0 END) AS des
    // ");
    //     $this->db->from('rkap_tenaga_kerja tk');
    //     $this->db->where('YEAR(tk.bulan)', $tahun);

    //     // Jika dipilih filter UPK / bagian
    //     if ($upk) {
    //         $this->db->where('tk.bagian', $upk);
    //     }

    //     // Group per pegawai per bagian
    //     $this->db->group_by('tk.bagian, tk.nama');
    //     $this->db->order_by('tk.bagian, tk.jabatan, tk.nama');

    //     return $this->db->get()->result();
    // }


    public function hitung_komponen($pegawai, $gaji_pokok, $j_istri, $j_anak)
    {
        // Hitung tunjangan sesuai aturan
        $tunj_istri = 0.10 * $gaji_pokok;
        $tunj_anak = 0.05 * $gaji_pokok * $j_anak;

        // Tunjangan transport & makan tergantung status pegawai
        $hari_kerja = 22;
        if ($pegawai['status_pegawai'] == 'Karyawan Tetap') {
            $tunj_transport = 15000 * $hari_kerja;
            $uang_makan = 10000 * $hari_kerja;
        } else { // Kontrak
            $tunj_transport = 12500 * $hari_kerja;
            $uang_makan = 5000 * $hari_kerja;
        }

        $total = $gaji_pokok + $tunj_istri + $tunj_anak  + $tunj_transport + $uang_makan;

        return [
            't_istri' => $tunj_istri,
            't_anak' => $tunj_anak,
            't_transport' => $tunj_transport,
            'uang_makan' => $uang_makan,
            'total_gaji' => $total,
        ];
    }

    public function generate_biaya()
    {
        $tahun = $this->input->get('tahun') ?: date('Y') + 1;

        // --- Mapping bagian → cabang_id ---
        $bagian_ke_cabang = [
            'bondowoso' => '01',
            'sukosari1' => '02',
            'maesan' => '03',
            'tegalampel' => '04',
            'tapen' => '05',
            'prajekan' => '06',
            'tlogosari' => '07',
            'wringin' => '08',
            'curahdami' => '09',
            'tamanan' => '11',
            'tenggarang' => '12',
            'tamankrocok' => '14',
            'wonosari' => '15',
            'klabang' => '16',
            'sukosari2' => '22',
            'umum' => '23',
            'keuangan' => '24',
            'langganan' => '25',
            'perencanaan' => '27',
            'pemeliharaan' => '26',
            'spi' => '28',
        ];

        // --- Mapping bagian → no_per_id (2 digit terakhir) ---
        $no_per_id = [
            'bondowoso' => '01',
            'sukosari1' => '02',
            'maesan' => '03',
            'tegalampel' => '04',
            'tapen' => '05',
            'prajekan' => '06',
            'tlogosari' => '07',
            'wringin' => '08',
            'curahdami' => '09',
            'tamanan' => '10',
            'tenggarang' => '11',
            'tamankrocok' => '12',
            'wonosari' => '13',
            'klabang' => '14',
            'sukosari2' => '15',
            'umum' => '00',
            'keuangan' => '00',
            'langganan' => '00',
            'perencanaan' => '00',
            'pemeliharaan' => '00',
            'spi' => '00',
        ];

        // --- Mapping kode perkiraan per kategori (Teknik) ---
        $kode_per_teknik = [
            'Gaji Pokok'      => '93.01.11',
            'Tunjangan'       => '93.01.12',
            'Uang Makan'      => '93.01.12',
            'BPJS Kesehatan'  => '93.01.22',
            'BPJS TK'         => '93.01.23',
            'Dapenmapamsi'    => '93.01.30',
        ];

        // --- Mapping kode perkiraan per kategori (Administrasi) ---
        $kode_per_administrasi = [
            'Gaji Pokok'      => '96.01.01',
            'Tunjangan'       => '96.01.02',
            'Uang Makan'      => '96.01.12',
            'BPJS Kesehatan'  => '96.08.11',
            'BPJS TK'         => '96.08.10',
            'Dapenmapamsi'    => '96.01.03',
        ];

        // --- Ambil daftar bagian + kategori dari rkap_tenaga_kerja ---
        $bagian_list = $this->db->select('DISTINCT(bagian), kategori')
            ->get('rkap_tenaga_kerja')
            ->result();

        foreach ($bagian_list as $b) {
            $bagian = strtolower($b->bagian);
            $kategori = strtolower($b->kategori); // 'teknik' atau 'administrasi'

            if (!isset($bagian_ke_cabang[$bagian]) || !isset($no_per_id[$bagian])) continue;

            $cabang_id = $bagian_ke_cabang[$bagian];
            $kode_suffix = $no_per_id[$bagian];

            // Ambil bulan yang tersedia di tabel tenaga kerja untuk bagian & kategori ini
            $bulan_list = $this->db->select('DISTINCT(bulan) as bulan')
                ->where('bagian', $b->bagian)
                ->where('kategori', $b->kategori)          // <-- penting: filter kategori
                ->where('YEAR(bulan)', $tahun)
                ->get('rkap_tenaga_kerja')
                ->result();

            foreach ($bulan_list as $bln) {
                $bulan = $bln->bulan;

                // === Hitung total kategori utama hanya untuk PEGAWAI (tanpa Direktur) dan hanya untuk kategori ini ===
                $data_sum = $this->db->select('
                SUM(CASE WHEN jabatan NOT LIKE "%Direktur%" THEN gaji_pokok ELSE 0 END) AS gaji_pokok,
                SUM(CASE WHEN jabatan NOT LIKE "%Direktur%" THEN (t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS tunjangan,
                SUM(CASE WHEN jabatan NOT LIKE "%Direktur%" THEN bpjs_kesehatan ELSE 0 END) AS bpjs_kesehatan,
                SUM(CASE WHEN jabatan NOT LIKE "%Direktur%" THEN bpjs_tk ELSE 0 END) AS bpjs_tk,
                SUM(CASE WHEN jabatan NOT LIKE "%Direktur%" THEN dapenmapamsi ELSE 0 END) AS dapenmapamsi
            ')
                    ->where('bagian', $b->bagian)
                    ->where('kategori', $b->kategori)          // <-- filter kategori
                    ->where('bulan', $bulan)
                    ->get('rkap_tenaga_kerja')
                    ->row();

                // === Hitung total khusus untuk DIREKTUR (jika ada), juga filter kategori ===
                $data_direktur = $this->db->select('
                SUM(gaji_pokok) AS gaji_pokok,
                SUM(t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) AS tunjangan,
                SUM(bpjs_kesehatan) AS bpjs_kesehatan,
                SUM(bpjs_tk) AS bpjs_tk,
                SUM(dapenmapamsi) AS dapenmapamsi
            ')
                    ->where('bagian', $b->bagian)
                    ->where('kategori', $b->kategori)          // <-- filter kategori
                    ->where('bulan', $bulan)
                    ->where('jabatan LIKE', '%Direktur%')
                    ->get('rkap_tenaga_kerja')
                    ->row();

                // === Siapkan dua set kategori: Pegawai & Direktur (jika ada nilainya) ===
                $kategori_set = [
                    'Pegawai'   => $data_sum,
                    'Direktur'  => $data_direktur,
                ];

                foreach ($kategori_set as $uraian => $data) {
                    // Skip jika semua nilai 0 / null
                    if (
                        (empty($data->gaji_pokok) || $data->gaji_pokok == 0) &&
                        (empty($data->tunjangan)   || $data->tunjangan == 0) &&
                        (empty($data->bpjs_kesehatan) || $data->bpjs_kesehatan == 0) &&
                        (empty($data->bpjs_tk) || $data->bpjs_tk == 0) &&
                        (empty($data->dapenmapamsi) || $data->dapenmapamsi == 0)
                    ) continue;

                    // Siapkan daftar kategori yang akan dimasukkan
                    $kategori_list = [
                        'Gaji Pokok'     => (float)$data->gaji_pokok,
                        'Tunjangan'      => (float)$data->tunjangan,
                        'BPJS Kesehatan' => (float)$data->bpjs_kesehatan,
                        'BPJS TK'        => (float)$data->bpjs_tk,
                        'Dapenmapamsi'   => (float)$data->dapenmapamsi,
                    ];

                    foreach ($kategori_list as $nama_kategori => $nilai) {
                        if ($nilai == 0 || $nilai === null) continue;

                        // Tentukan mapping kode awal berdasarkan kategori (teknik/administrasi)
                        $kode_awal = ($kategori == 'teknik')
                            ? $kode_per_teknik[$nama_kategori]
                            : $kode_per_administrasi[$nama_kategori];

                        // Bentuk no_per_id lengkap (contoh: 93.01.11.02)
                        $no_per_id_final = $kode_awal . '.' . $kode_suffix;

                        // Data insert ke tabel biaya
                        $insert_data = [
                            'cabang_id'   => $cabang_id,
                            'bulan'       => $bulan,
                            'uraian'      => $uraian,
                            'no_per_id'   => $no_per_id_final,
                            'pagu'        => $nilai,
                            'ptgs_upload' => $this->session->userdata('nama_lengkap'),
                        ];

                        // Cek jika sudah ada, update; kalau belum, insert
                        $cek = $this->db->where([
                            'cabang_id' => $cabang_id,
                            'bulan'     => $bulan,
                            'no_per_id' => $no_per_id_final,
                            'uraian'    => $uraian,
                        ])->get('rkap_biaya')->row();

                        if ($cek) {
                            $this->db->where('id_by', $cek->id_by)->update('rkap_biaya', $insert_data);
                        } else {
                            $this->db->insert('rkap_biaya', $insert_data);
                        }
                    }
                }
            }
        }

        $this->session->set_flashdata('info', '
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> Data Gaji berhasil digenerate untuk tahun ' . $tahun . '.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    ');

        redirect('lembar_kerja/arus_kas/tenaga_kerja?tahun_rkap=' . $tahun);
    }


    public function generate_biaya_amdk()
    {
        $tahun = $this->input->get('tahun') ?: date('Y') + 1;
        $cabang_id = '13'; // AMDK
        $bagian = 'amdk';

        // Ambil semua data tenaga kerja AMDK pada tahun tersebut
        $data_tk = $this->db->select('*')
            ->where('bagian', $bagian)
            ->where('YEAR(bulan)', $tahun)
            ->get('rkap_tenaga_kerja')
            ->result();

        // Jika tidak ada data tenaga kerja, tampilkan pesan gagal
        if (!$data_tk) {
            $this->session->set_flashdata('info', '
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> Tidak ada data tenaga kerja AMDK tahun ' . $tahun . '.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ');
            redirect('lembar_kerja/arus_kas/tenaga_kerja?tahun_rkap=' . $tahun);
            return;
        }

        // 🔹 Hapus data lama Manajer dan Pegawai untuk tahun yang sama
        $this->db->where('cabang_id', $cabang_id)
            ->where_in('uraian', ['Manajer', 'Pegawai'])
            ->where('YEAR(bulan)', $tahun)
            ->delete('rkap_amdk_biaya');

        // 🔹 Loop data tenaga kerja
        foreach ($data_tk as $row) {
            $bulan  = $row->bulan;
            $uraian = (strtolower($row->jabatan) == 'manajer') ? 'Manajer' : 'Pegawai';

            // Hitung total gaji dan dana pensiun
            $total_gaji = $row->gaji_pokok
                + $row->t_istri
                + $row->t_anak
                + $row->t_jabatan
                + $row->t_transport
                + $row->t_pangan
                + $row->t_perumahan
                + $row->uang_makan;

            $total_dapen = $row->bpjs_kesehatan + $row->bpjs_tk + $row->dapenmapamsi;

            // Daftar kategori biaya yang akan disimpan
            $kategori_list = [
                ['kode' => '98.02.01.01', 'nilai' => $total_gaji],
                ['kode' => '98.02.01.02', 'nilai' => $total_dapen],
            ];

            foreach ($kategori_list as $data) {
                $nilai = $data['nilai'];
                if ($nilai == 0 || $nilai === null) continue;

                $insert_data = [
                    'cabang_id'   => $cabang_id,
                    'bulan'       => $bulan,
                    'uraian'      => $uraian,
                    'no_per_id'   => $data['kode'],
                    'pagu'        => $nilai,
                    'ptgs_upload' => $this->session->userdata('nama_lengkap'),
                ];

                // Insert langsung tanpa update (karena sudah hapus sebelumnya)
                $this->db->insert('rkap_amdk_biaya', $insert_data);
            }
        }

        // 🔹 Pesan sukses
        $this->session->set_flashdata('info', '
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> Data Biaya AMDK berhasil digenerate ulang untuk tahun ' . $tahun . '.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    ');

        redirect('lembar_kerja/arus_kas/tenaga_kerja?tahun_rkap=' . $tahun);
    }
    public function get_rekap_naker($tahun)
    {
        $query = $this->db->query("
        SELECT 
            kategori,
            bagian,
            SUM(CASE WHEN MONTH(bulan)=1 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS jan,
            SUM(CASE WHEN MONTH(bulan)=2 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS feb,
            SUM(CASE WHEN MONTH(bulan)=3 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS mar,
            SUM(CASE WHEN MONTH(bulan)=4 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS apr,
            SUM(CASE WHEN MONTH(bulan)=5 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS mei,
            SUM(CASE WHEN MONTH(bulan)=6 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS jun,
            SUM(CASE WHEN MONTH(bulan)=7 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS jul,
            SUM(CASE WHEN MONTH(bulan)=8 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS agu,
            SUM(CASE WHEN MONTH(bulan)=9 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS sep,
            SUM(CASE WHEN MONTH(bulan)=10 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS okt,
            SUM(CASE WHEN MONTH(bulan)=11 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS nov,
            SUM(CASE WHEN MONTH(bulan)=12 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS des,
            SUM(gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) AS total_tahun
        FROM rkap_tenaga_kerja
        WHERE YEAR(bulan) = ?
        GROUP BY kategori, bagian
        ORDER BY kategori, bagian
    ", [$tahun]);

        return $query->result();
    }

    // kode ini rekap gaji + bpjs dapenmapamsi
    // public function get_rekap_naker($tahun)
    // {
    //     $query = $this->db->query("
    //     SELECT 
    //         kategori,
    //         bagian,
    //         SUM(CASE WHEN MONTH(bulan)=1 THEN total_gaji ELSE 0 END) AS jan,
    //         SUM(CASE WHEN MONTH(bulan)=2 THEN total_gaji ELSE 0 END) AS feb,
    //         SUM(CASE WHEN MONTH(bulan)=3 THEN total_gaji ELSE 0 END) AS mar,
    //         SUM(CASE WHEN MONTH(bulan)=4 THEN total_gaji ELSE 0 END) AS apr,
    //         SUM(CASE WHEN MONTH(bulan)=5 THEN total_gaji ELSE 0 END) AS mei,
    //         SUM(CASE WHEN MONTH(bulan)=6 THEN total_gaji ELSE 0 END) AS jun,
    //         SUM(CASE WHEN MONTH(bulan)=7 THEN total_gaji ELSE 0 END) AS jul,
    //         SUM(CASE WHEN MONTH(bulan)=8 THEN total_gaji ELSE 0 END) AS agu,
    //         SUM(CASE WHEN MONTH(bulan)=9 THEN total_gaji ELSE 0 END) AS sep,
    //         SUM(CASE WHEN MONTH(bulan)=10 THEN total_gaji ELSE 0 END) AS okt,
    //         SUM(CASE WHEN MONTH(bulan)=11 THEN total_gaji ELSE 0 END) AS nov,
    //         SUM(CASE WHEN MONTH(bulan)=12 THEN total_gaji ELSE 0 END) AS des,
    //         SUM(total_gaji) AS total_tahun
    //     FROM rkap_tenaga_kerja
    //     WHERE YEAR(bulan) = ?
    //     GROUP BY kategori, bagian
    //     ORDER BY kategori, bagian
    // ", [$tahun]);

    //     return $query->result();
    // }

    // kode ini rekap gaji tanpa direktur
    // public function get_rekap_naker($tahun)
    // {
    //     $query = $this->db->query("
    //     SELECT 
    //         kategori,
    //         bagian,
    //         SUM(CASE WHEN MONTH(bulan)=1 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS jan,
    //         SUM(CASE WHEN MONTH(bulan)=2 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS feb,
    //         SUM(CASE WHEN MONTH(bulan)=3 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS mar,
    //         SUM(CASE WHEN MONTH(bulan)=4 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS apr,
    //         SUM(CASE WHEN MONTH(bulan)=5 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS mei,
    //         SUM(CASE WHEN MONTH(bulan)=6 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS jun,
    //         SUM(CASE WHEN MONTH(bulan)=7 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS jul,
    //         SUM(CASE WHEN MONTH(bulan)=8 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS agu,
    //         SUM(CASE WHEN MONTH(bulan)=9 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS sep,
    //         SUM(CASE WHEN MONTH(bulan)=10 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS okt,
    //         SUM(CASE WHEN MONTH(bulan)=11 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS nov,
    //         SUM(CASE WHEN MONTH(bulan)=12 THEN (gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) ELSE 0 END) AS des,
    //         SUM(gaji_pokok + t_istri + t_anak + t_jabatan + t_transport + t_pangan + t_perumahan + uang_makan) AS total_tahun
    //     FROM rkap_tenaga_kerja
    //     WHERE YEAR(bulan) = ?
    //       AND jabatan <> 'Direktur'
    //     GROUP BY kategori, bagian
    //     ORDER BY kategori, bagian
    // ", [$tahun]);

    //     return $query->result();
    // }

    public function simpan($data)
    {
        $this->db->insert('rkap_tenaga_kerja', $data);
    }

    public function get_pegawai($upk = null)
    {
        $this->db->select('tk.*');
        $this->db->from('rkap_pegawai tk');
        $this->db->where('aktif', 1);
        if ($upk) {
            $this->db->where('tk.bagian', $upk);
        }
        return $this->db->get()->result();
    }

    public function get_pegawai_by_id($id)
    {
        $this->db->select('tk.*');
        $this->db->from('rkap_pegawai tk');
        $this->db->where('tk.id', $id);
        return $this->db->get()->row_array();
    }
}
