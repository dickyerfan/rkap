<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/rkap_amdk/gaji_amdk') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <?php
                                $upk = isset($upk) ? $upk : '';
                                $tahun_sekarang = date('Y') + 1;
                                $tahun_rkap = isset($tahun_rkap) ? (int)$tahun_rkap : $tahun_sekarang;

                                $tahun_mulai = $tahun_sekarang - 10;
                                $tahun_selesai = $tahun_sekarang;

                                if ($tahun_rkap > $tahun_sekarang) {
                                    $tahun_selesai = $tahun_rkap;
                                }
                                ?>
                                <select name="tahun_rkap" class="form-select" style="width: 120px; margin-left:10px;">
                                    <?php for ($i = $tahun_mulai; $i <= $tahun_selesai; $i++) : ?>
                                        <option value="<?= $i ?>" <?= $i == $tahun_rkap  ? 'selected' : '' ?>>
                                            <?= $i ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>

                        <div class="navbar-nav ms-2">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/gaji_amdk') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <!-- <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/rkap_amdk/gaji_amdk/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <div class="navbar-nav">
                                <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/gaji_amdk/form_generate') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Generate Ke Cetet</button> </a>
                            </div>
                        <?php endif; ?> -->
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">

                    <div class="row justify-content-center">
                        <div class="col-md-8 col-12">
                            <div class="container-fluid mt-4 mb-4">
                                <div class="card shadow-lg border-0">
                                    <div class="card-body p-4">

                                        <div class="info-wrapper d-flex align-items-center">

                                            <div class="me-3 icon-box">
                                                <i class="fas fa-info-circle text-primary info-icon"></i>
                                            </div>

                                            <div class="text-box">
                                                <h4 class="fw-bold mb-1 text-primary text-title">Informasi Cetak</h4>

                                                <p class="mb-0 text-desc">
                                                    <strong>Biaya Tenaga Kerja AMDK</strong> dapat dicetak melalui menu:
                                                </p>

                                                <div class="mt-2 flow-badge">
                                                    <span class="badge bg-dark px-3 py-2 mb-1">
                                                        <i class="fas fa-stream"></i> Arus Kas
                                                    </span>
                                                    <span class="mx-1 arrow">→</span>

                                                    <span class="badge bg-success px-3 py-2 mb-1">
                                                        <i class="fas fa-user-cog"></i> Pengeluaran Tenaga Kerja
                                                    </span>
                                                    <span class="mx-1 arrow">→</span>

                                                    <span class="badge bg-primary px-3 py-2 mb-1">
                                                        <i class="fas fa-water"></i> Pilih AMDK
                                                    </span>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        .card {
                            border-radius: 1rem;
                        }

                        /* ============================
       DESKTOP (TETAP SEPERTI SEMULA)
       ============================ */
                        .info-wrapper {
                            display: flex;
                            align-items: center;
                        }

                        .info-icon {
                            font-size: 40px;
                        }

                        .text-title {
                            font-size: 1.4rem;
                        }

                        .text-desc {
                            font-size: 1.1rem;
                        }

                        /* ============================
       MOBILE (<576px)
       ============================ */
                        @media (max-width: 576px) {

                            .info-wrapper {
                                flex-direction: column;
                                /* Ikon ke atas, teks ke bawah */
                                text-align: center;
                            }

                            .icon-box {
                                margin-bottom: 10px;
                            }

                            .info-icon {
                                font-size: 32px;
                                /* perkecil ikon */
                            }

                            .text-title {
                                font-size: 1.2rem;
                            }

                            .text-desc {
                                font-size: 1rem;
                            }

                            .flow-badge {
                                display: flex;
                                flex-wrap: wrap;
                                /* otomatis turun kalau sempit */
                                justify-content: center;
                            }

                            .flow-badge .badge {
                                padding: 6px 10px !important;
                                font-size: 0.9rem;
                            }

                            .flow-badge .arrow {
                                display: none;
                                /* sembunyikan tanda panah di mobile agar tidak berantakan */
                            }
                        }
                    </style>
                </div>
            </div>
        </div>
    </main>