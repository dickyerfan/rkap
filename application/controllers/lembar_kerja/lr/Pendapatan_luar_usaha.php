<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendapatan_luar_usaha extends MY_Controller
// class di ganti mengambil dari MY_Controller letaknya di application/core
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_pendapatan_luar_usaha');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;
        $this->session->set_userdata('tahun_rkap', $tahun);

        $res = $this->Model_pendapatan_luar_usaha->getPendapatanLuarUsaha($tahun);

        $items = $res['items'];   // keyed by kode
        $order = $res['order'];   // ordered list of kode (string)

        $group_order = [];
        foreach ($order as $kode) {
            $parts = explode('.', $kode);
            if (!isset($parts[1])) continue;
            $grp = $parts[0] . '.' . $parts[1]; // e.g. '88.01'
            if (!in_array($grp, $group_order)) $group_order[] = $grp;
        }

        $groups = []; // final structured data

        foreach ($group_order as $grp) {
            $group_parent_code = $grp . '.00'; // e.g. '88.01.00'
            $group_label = ($grp === '88.01') ? 'Pendapatan Lain-Lain' : (($grp === '88.02') ? 'Pendapatan AMDK' : $grp);

            // collect unique level-3 parents under this group (preserve order)
            $parent3_list = [];
            foreach ($order as $kode) {
                if (strpos($kode, $grp . '.') !== 0) continue;
                $parts = explode('.', $kode);
                if (count($parts) >= 3) {
                    $p3 = $parts[0] . '.' . $parts[1] . '.' . $parts[2]; // e.g. '88.01.02'
                    if (!in_array($p3, $parent3_list)) $parent3_list[] = $p3;
                }
            }

            $parents = [];
            $handled_codes = [];

            foreach ($parent3_list as $p3) {
                $prow = [
                    'kode' => $p3,
                    'name' => isset($items[$p3]) ? $items[$p3]['name'] : (isset($items[$p3 . '.00']) ? $items[$p3 . '.00']['name'] : ('Jumlah ' . $p3)),
                    'bulan' => array_fill(1, 12, 0),
                    'total' => 0,
                    'children' => []
                ];

                // aggregate into parent from all items that start with parent (parent itself + children)
                foreach ($order as $kode) {
                    if (strpos($kode, $p3) !== 0) continue; // not part of this parent
                    // skip codes with less than 3 segments (shouldn't happen)
                    $parts = explode('.', $kode);
                    if (count($parts) < 3) continue;

                    // add to parent totals (includes parent if exists)
                    if (isset($items[$kode])) {
                        for ($m = 1; $m <= 12; $m++) {
                            $prow['bulan'][$m] += $items[$kode]['bulan'][$m];
                        }
                        $prow['total'] += $items[$kode]['total'];
                    }

                    // mark handled
                    if (!in_array($kode, $handled_codes)) $handled_codes[] = $kode;

                    // children display policy:
                    // - For 88.02 group we DON'T show detail level-4 children (just keep aggregated in parent)
                    // - For other groups we show level-4 children (exactly 4 segments)
                    if ($grp !== '88.02') {
                        if (count($parts) === 4) {
                            // child node
                            $child = $items[$kode] ?? ['kode' => $kode, 'name' => '', 'bulan' => array_fill(1, 12, 0), 'total' => 0];
                            $prow['children'][] = $child;
                        }
                    }
                } // end foreach order

                $parents[] = $prow;
            } // end each parent3

            // any leftover items in group that were not part of a parent3 (e.g. a code like 88.01.00 or other)
            $leftovers = [];
            foreach ($order as $kode) {
                if (strpos($kode, $grp . '.') !== 0) continue;
                if (in_array($kode, $handled_codes)) continue;

                // skip codes with less than 3 segments except group parent code (grp.'.00')
                $parts = explode('.', $kode);
                if (count($parts) < 3 && $kode !== $group_parent_code) continue;

                // add as leftover (will be shown after parents)
                $leftovers[$kode] = $items[$kode] ?? ['kode' => $kode, 'name' => '', 'bulan' => array_fill(1, 12, 0), 'total' => 0];
                $handled_codes[] = $kode;
            }

            // compute group totals (sum of parents + leftovers)
            $group_totals = array_fill(1, 12, 0);
            $group_sum = 0;

            // sum parents
            foreach ($parents as $p) {
                for ($m = 1; $m <= 12; $m++) $group_totals[$m] += $p['bulan'][$m];
                $group_sum += $p['total'];
            }
            // add leftovers (if any)
            foreach ($leftovers as $ld) {
                for ($m = 1; $m <= 12; $m++) $group_totals[$m] += $ld['bulan'][$m];
                $group_sum += $ld['total'];
            }

            // get group header values if exist (88.01.00)
            $group_header = isset($items[$group_parent_code]) ? $items[$group_parent_code] : null;

            $groups[$grp] = [
                'group_code' => $grp,
                'group_parent_code' => $group_parent_code,
                'group_label' => $group_label,
                'header' => $group_header,
                'parents' => $parents,
                'leftovers' => $leftovers,
                'totals' => $group_totals,
                'total_sum' => $group_sum
            ];
        } // end groups

        // grand totals across groups
        $grand_totals = array_fill(1, 12, 0);
        $grand_sum = 0;
        foreach ($groups as $g) {
            for ($m = 1; $m <= 12; $m++) $grand_totals[$m] += $g['totals'][$m];
            $grand_sum += $g['total_sum'];
        }

        $data = [
            'tahun' => $tahun,
            'groups' => $groups,
            'group_order' => $group_order,
            'grand_totals' => $grand_totals,
            'grand_sum' => $grand_sum
        ];

        $data['title'] = "RENCANA PENDAPATAN DILUAR USAHA";

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/pendapatan_luar_usaha/view_pendapatan_luar_usaha', $data);
        $this->load->view('templates/footer');
    }
    // public function index()
    // {
    //     $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;
    //     $data = [];
    //     $data['tahun'] = $tahun;

    //     // ambil data grouped
    //     $rekap = $this->Model_pendapatan_luar_usaha->getPendapatanRekapGrouped($tahun);

    //     $data['groups'] = $rekap['groups'];
    //     $data['group_order'] = $rekap['group_order'];
    //     $data['parent_subtotals'] = $rekap['parent_subtotals'];
    //     $data['grand_totals'] = $rekap['grand_totals'];
    //     $data['grand_sum'] = $rekap['grand_sum'];
    //     $data['name_map'] = $rekap['name_map'];

    //     $data['title'] = "RENCANA PENDAPATAN DILUAR USAHA";

    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/navbar');
    //     $this->load->view('templates/sidebar');
    //     $this->load->view('lembar_kerja/lr/pendapatan_luar_usaha/view_pendapatan_luar_usaha', $data);
    //     $this->load->view('templates/footer');
    // }

    // public function index()
    // {
    //     $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;
    //     $data['tahun'] = $tahun;

    //     // simpan ke session utk keperluan export PDF
    //     $this->session->set_userdata('tahun_rkap', $tahun);

    //     $rows = $this->Model_pendapatan_luar_usaha->getPendapatanLuarUsaha($tahun);

    //     // siapkan struktur data per kode
    //     $data_rows = [];
    //     foreach ($rows as $row) {
    //         $kode = $row['kode'];
    //         $name = $row['name'];

    //         if (!isset($data_rows[$kode])) {
    //             $data_rows[$kode] = [
    //                 'kode' => $kode,
    //                 'name' => $name,
    //                 'bulan' => [],
    //                 'total' => 0
    //             ];
    //         }

    //         if (!empty($row['bulan'])) {
    //             $month = (int)date('n', strtotime($row['bulan']));
    //             $pagu  = (float)$row['pagu'];
    //             $data_rows[$kode]['bulan'][$month] = $pagu;
    //             $data_rows[$kode]['total'] += $pagu;
    //         }
    //     }

    //     // daftar kelompok utama
    //     $kelompok = [
    //         '88.01' => 'Jumlah Pendapatan Lain-lain',
    //         '88.02' => 'Jumlah Pendapatan AMDK',
    //     ];

    //     // kelompokkan
    //     $groups = [];
    //     foreach ($kelompok as $prefix => $label) {
    //         $groups[$prefix] = [
    //             'label' => $label,
    //             'items' => [],
    //             'totals' => array_fill(1, 12, 0)
    //         ];

    //         foreach ($data_rows as $kode => $row) {
    //             if (strpos($kode, $prefix) === 0) {
    //                 // skip detail untuk AMDK (contoh 88.02.01.01 dll)
    //                 if ($prefix == '88.02') {
    //                     $parts = explode('.', $kode);
    //                     if (count($parts) > 3) continue;
    //                 }

    //                 $groups[$prefix]['items'][] = $row;

    //                 // hitung subtotal group
    //                 foreach (range(1, 12) as $m) {
    //                     $groups[$prefix]['totals'][$m] += $row['bulan'][$m] ?? 0;
    //                 }
    //             }
    //         }
    //     }

    //     $data['tahun'] = $tahun;
    //     $data['groups'] = $groups;
    //     $data['title'] = "RENCANA PENDAPATAN DILUAR USAHA";

    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/navbar');
    //     $this->load->view('templates/sidebar');
    //     $this->load->view('lembar_kerja/lr/pendapatan_luar_usaha/view_pendapatan_luar_usaha', $data);
    //     $this->load->view('templates/footer');
    // }

    public function export_pdf()
    {
        $tahun = $this->session->userdata('tahun_rkap');

        $res = $this->Model_pendapatan_luar_usaha->getPendapatanLuarUsaha($tahun);

        $items = $res['items'];   // keyed by kode
        $order = $res['order'];   // ordered list of kode (string)

        $group_order = [];
        foreach ($order as $kode) {
            $parts = explode('.', $kode);
            if (!isset($parts[1])) continue;
            $grp = $parts[0] . '.' . $parts[1]; // e.g. '88.01'
            if (!in_array($grp, $group_order)) $group_order[] = $grp;
        }

        $groups = []; // final structured data

        foreach ($group_order as $grp) {
            $group_parent_code = $grp . '.00'; // e.g. '88.01.00'
            $group_label = ($grp === '88.01') ? 'Pendapatan Lain-Lain' : (($grp === '88.02') ? 'Pendapatan AMDK' : $grp);

            // collect unique level-3 parents under this group (preserve order)
            $parent3_list = [];
            foreach ($order as $kode) {
                if (strpos($kode, $grp . '.') !== 0) continue;
                $parts = explode('.', $kode);
                if (count($parts) >= 3) {
                    $p3 = $parts[0] . '.' . $parts[1] . '.' . $parts[2]; // e.g. '88.01.02'
                    if (!in_array($p3, $parent3_list)) $parent3_list[] = $p3;
                }
            }

            $parents = [];
            $handled_codes = [];

            foreach ($parent3_list as $p3) {
                $prow = [
                    'kode' => $p3,
                    'name' => isset($items[$p3]) ? $items[$p3]['name'] : (isset($items[$p3 . '.00']) ? $items[$p3 . '.00']['name'] : ('Jumlah ' . $p3)),
                    'bulan' => array_fill(1, 12, 0),
                    'total' => 0,
                    'children' => []
                ];

                // aggregate into parent from all items that start with parent (parent itself + children)
                foreach ($order as $kode) {
                    if (strpos($kode, $p3) !== 0) continue; // not part of this parent
                    // skip codes with less than 3 segments (shouldn't happen)
                    $parts = explode('.', $kode);
                    if (count($parts) < 3) continue;

                    // add to parent totals (includes parent if exists)
                    if (isset($items[$kode])) {
                        for ($m = 1; $m <= 12; $m++) {
                            $prow['bulan'][$m] += $items[$kode]['bulan'][$m];
                        }
                        $prow['total'] += $items[$kode]['total'];
                    }

                    // mark handled
                    if (!in_array($kode, $handled_codes)) $handled_codes[] = $kode;

                    // children display policy:
                    // - For 88.02 group we DON'T show detail level-4 children (just keep aggregated in parent)
                    // - For other groups we show level-4 children (exactly 4 segments)
                    if ($grp !== '88.02') {
                        if (count($parts) === 4) {
                            // child node
                            $child = $items[$kode] ?? ['kode' => $kode, 'name' => '', 'bulan' => array_fill(1, 12, 0), 'total' => 0];
                            $prow['children'][] = $child;
                        }
                    }
                } // end foreach order

                $parents[] = $prow;
            } // end each parent3

            // any leftover items in group that were not part of a parent3 (e.g. a code like 88.01.00 or other)
            $leftovers = [];
            foreach ($order as $kode) {
                if (strpos($kode, $grp . '.') !== 0) continue;
                if (in_array($kode, $handled_codes)) continue;

                // skip codes with less than 3 segments except group parent code (grp.'.00')
                $parts = explode('.', $kode);
                if (count($parts) < 3 && $kode !== $group_parent_code) continue;

                // add as leftover (will be shown after parents)
                $leftovers[$kode] = $items[$kode] ?? ['kode' => $kode, 'name' => '', 'bulan' => array_fill(1, 12, 0), 'total' => 0];
                $handled_codes[] = $kode;
            }

            // compute group totals (sum of parents + leftovers)
            $group_totals = array_fill(1, 12, 0);
            $group_sum = 0;

            // sum parents
            foreach ($parents as $p) {
                for ($m = 1; $m <= 12; $m++) $group_totals[$m] += $p['bulan'][$m];
                $group_sum += $p['total'];
            }
            // add leftovers (if any)
            foreach ($leftovers as $ld) {
                for ($m = 1; $m <= 12; $m++) $group_totals[$m] += $ld['bulan'][$m];
                $group_sum += $ld['total'];
            }

            // get group header values if exist (88.01.00)
            $group_header = isset($items[$group_parent_code]) ? $items[$group_parent_code] : null;

            $groups[$grp] = [
                'group_code' => $grp,
                'group_parent_code' => $group_parent_code,
                'group_label' => $group_label,
                'header' => $group_header,
                'parents' => $parents,
                'leftovers' => $leftovers,
                'totals' => $group_totals,
                'total_sum' => $group_sum
            ];
        } // end groups

        // grand totals across groups
        $grand_totals = array_fill(1, 12, 0);
        $grand_sum = 0;
        foreach ($groups as $g) {
            for ($m = 1; $m <= 12; $m++) $grand_totals[$m] += $g['totals'][$m];
            $grand_sum += $g['total_sum'];
        }

        $data = [
            'tahun' => $tahun,
            'groups' => $groups,
            'group_order' => $group_order,
            'grand_totals' => $grand_totals,
            'grand_sum' => $grand_sum
        ];

        $data['title'] = "RENCANA PENDAPATAN DILUAR USAHA";

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_pendapatan_luar_usaha_{$tahun}.pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/lr/pendapatan_luar_usaha/laporan_pdf', $data);
    }

    public function tambah($kode = null)
    {
        $tahun = $this->input->get('tahun') ?: date('Y') + 1;
        $cabang_id = $this->input->get('cabang_id') ?: 24;

        // ambil list kode perkiraan (misal hanya untuk pendapatan luar usaha & amdk)
        $no_per_list = $this->db->like('kode', '88.01')->get('no_per')->result_array();

        $data = [
            'title'      => 'Input Pendapatan',
            'tahun'      => $tahun,
            'cabang_id'  => $cabang_id,
            'no_per_list' => $no_per_list
        ];

        $data['title'] = "FORM INPUT RENCANA PENDAPATAN DILUAR USAHA";

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/pendapatan_luar_usaha/upload_pendapatan_luar_usaha', $data);
        $this->load->view('templates/footer');
    }

    public function save()
    {
        // Pastikan $tahun terisi karena sudah diperbaiki di View
        $tahun      = $this->input->post('tahun');
        $cabang_id  = $this->input->post('cabang_id');
        $kode       = $this->input->post('kode'); // no_per_id

        // Validasi dasar
        if (empty($tahun) || empty($cabang_id) || empty($kode)) {
            // Tambahkan logic error/flashdata jika data penting kosong
            $this->session->set_flashdata('error', 'Data Tahun, Cabang, atau Kode Perkiraan tidak boleh kosong.');
            redirect('lembar_kerja/lr/pendapatan_luar_usaha');
            return;
        }

        $is_success = true;

        for ($i = 1; $i <= 12; $i++) {
            $nilai = $this->input->post('bulan_' . $i);

            // Hanya proses jika nilai diinput (tidak kosong)
            if ($nilai !== null && $nilai !== '') {

                // Format tanggal yang BENAR: YYYY-MM-DD
                $tanggal_bulan = $tahun . '-' . str_pad($i, 2, '0', STR_PAD_LEFT) . '-01';

                $data = [
                    'cabang_id' => $cabang_id,
                    'no_per_id' => $kode,
                    'bulan'     => $tanggal_bulan, // Gunakan variabel yang sudah diformat
                    'pagu'      => str_replace(',', '', $nilai)
                ];

                // 1. Cek apakah sudah ada data
                $cek = $this->db->get_where('rkap_rekap', [
                    'no_per_id' => $kode,
                    'cabang_id' => $cabang_id,
                    'bulan'     => $tanggal_bulan // Gunakan variabel yang sama untuk cek
                ])->row();

                // 2. Simpan atau Update
                if ($cek) {
                    // UPDATE data yang sudah ada
                    if (!$this->db->where('id', $cek->id)->update('rkap_rekap', $data)) {
                        $is_success = false;
                    }
                } else {
                    // INSERT data baru
                    if (!$this->db->insert('rkap_rekap', $data)) {
                        $is_success = false;
                    }
                }
            }
            // Jika nilai kosong (null atau ''), baris ini diabaikan (tidak di-update/insert)
        }

        // Redirect dengan pesan status
        if ($is_success) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Pendapatan diluar Usaha  berhasil di input.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal,</strong> Pendapatan diluar Usaha gagal di input.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
        }

        // Redirect ke halaman sebelumnya
        redirect('lembar_kerja/lr/pendapatan_luar_usaha?tahun=' . $tahun);
    }

    // public function save()
    // {
    //     $tahun     = $this->input->post('tahun');
    //     $cabang_id = $this->input->post('cabang_id');
    //     $kode      = $this->input->post('kode'); // kode/no_per_id

    //     for ($i = 1; $i <= 12; $i++) {
    //         $nilai = $this->input->post('bulan_' . $i);

    //         if ($nilai !== null && $nilai !== '') {
    //             $data = [
    //                 'cabang_id' => $cabang_id,
    //                 'no_per_id' => $kode,
    //                 'bulan'     => $tahun . '-' . str_pad($i, 2, '0', STR_PAD_LEFT) . '-01',
    //                 'pagu'      => str_replace(',', '', $nilai)
    //             ];

    //             // cek apakah sudah ada data
    //             $cek = $this->db->get_where('rkap_rekap', [
    //                 'no_per_id' => $kode,
    //                 'cabang_id' => $cabang_id,
    //                 'bulan'     => $data['bulan']
    //             ])->row();

    //             if ($cek) {
    //                 $this->db->where('id', $cek->id)->update('rkap_rekap', $data);
    //             } else {
    //                 $this->db->insert('rkap_rekap', $data);
    //             }
    //         }
    //     }

    //     redirect('lembar_kerja/lr/pendapatan_luar_usaha?tahun=' . $tahun);
    // }
}
