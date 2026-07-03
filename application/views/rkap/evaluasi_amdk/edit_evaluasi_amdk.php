<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('rkap/Evaluasi_amdk') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('rkap/evaluasi_amdk/update_evaluasi_amdk') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <input type="hidden" name="id_evaluasi_amdk" id="id_evaluasi_amdk" value="<?= $evaluasi_amdk->id_evaluasi_amdk; ?>">
                                <div class="form-group">
                                    <label for="tahun_rkap">Tahun Pembuatan RKAP :</label>
                                    <select name="tahun_rkap" class="form-select" disabled>
                                        <?php
                                        $mulai = date('Y') - 2;
                                        for ($i = $mulai; $i < $mulai + 11; $i++) {
                                            $sel = $i == date('Y') ? ' selected="selected"' : '';
                                            echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('tahun_rkap'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="rkap">RKAP :</label>
                                    <input type="number" step="1" class="form-control" id="rkap" name="rkap" value="<?= $evaluasi_amdk->rkap; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('rkap'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="realisasi">Realisasi :</label>
                                    <input type="number" step="1" class="form-control" id="realisasi" name="realisasi" value="<?= $evaluasi_amdk->realisasi; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('realisasi'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="selisih">Naik/Turun :</label>
                                    <input type="text" class="form-control" id="selisih" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="persen">Persen Naik/Turun :</label>
                                    <input type="text" class="form-control" id="persen" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center">
                                <button class="neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-edit"></i> Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rkapInput = document.getElementById('rkap');
            const realisasiInput = document.getElementById('realisasi');
            const selisihInput = document.getElementById('selisih');
            const persenInput = document.getElementById('persen');

            function formatAngka(nilai) {
                return new Intl.NumberFormat('id-ID').format(nilai);
            }

            function hitungNaikTurun() {
                const rkap = Number(rkapInput.value) || 0;
                const realisasi = Number(realisasiInput.value) || 0;
                const selisih = realisasi - rkap;
                const persen = rkap !== 0 ? (selisih / rkap) * 100 : 0;

                selisihInput.value = formatAngka(selisih);
                persenInput.value = persen.toLocaleString('id-ID', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) + ' %';

                selisihInput.classList.toggle('text-danger', selisih < 0);
                selisihInput.classList.toggle('text-success', selisih >= 0);
                persenInput.classList.toggle('text-danger', persen < 0);
                persenInput.classList.toggle('text-success', persen >= 0);
            }

            rkapInput.addEventListener('input', hitungNaikTurun);
            realisasiInput.addEventListener('input', hitungNaikTurun);
            hitungNaikTurun();
        });
    </script>
