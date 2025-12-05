<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penerimaan_luar_usaha extends MY_Controller
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

        $data['title'] = "RENCANA PENERIMAAN DILUAR USAHA";

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/penerimaan_luar_usaha/view_penerimaan_luar_usaha', $data);
        $this->load->view('templates/footer');
    }


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

        $data['title'] = "RENCANA PENERIMAAN DILUAR USAHA";

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_pendapatan_luar_usaha_{$tahun}.pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/arus_kas/penerimaan_luar_usaha/laporan_pdf', $data);
    }

    public function generate()
    {
        $tahun = $this->session->userdata('tahun_rkap');
        $res = $this->Model_pendapatan_luar_usaha->getPendapatanLuarUsaha($tahun);

        // ambil semua group dan totalnya
        $groups = [];
        $grand_totals = array_fill(1, 12, 0);

        $data = $res['items'];
        $order = $res['order'];

        // hitung total grand total per bulan (semua kode 88.*)
        foreach ($data as $item) {
            if (strpos($item['kode'], '88.') === 0) {
                for ($m = 1; $m <= 12; $m++) {
                    $grand_totals[$m] += $item['bulan'][$m];
                }
            }
        }

        // simpan ke tabel rkap_arus_kas
        $this->load->database();

        $awal_tahun = "$tahun-01-01";
        $akhir_tahun = "$tahun-12-01";
        $this->db->where('no_per_id', '88');
        $this->db->where('bulan >=', $awal_tahun);
        $this->db->where('bulan <=', $akhir_tahun);
        $this->db->delete('rkap_arus_kas');

        foreach ($grand_totals as $bulan => $nilai) {
            $bulan_date = "$tahun-" . str_pad($bulan, 2, '0', STR_PAD_LEFT) . "-01";

            $data_insert = [
                'cabang_id'     => 24, // sesuaikan jika perlu
                'no_per_id'  => '88',
                'bulan'      => $bulan_date,
                'pagu'       => $nilai,
                'status'     => 1,
            ];

            $this->db->insert('rkap_arus_kas', $data_insert);
        }
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data penerimaan non air berhasil digenerate ke  Arus Kas.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
        );
        redirect('lembar_kerja/arus_kas/penerimaan_luar_usaha');
    }
}
