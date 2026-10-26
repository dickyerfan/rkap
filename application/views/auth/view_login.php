<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Portal RKAP Perumdam Ijen Tirta Bondowoso" />
    <title>RKAP | <?= $title ?></title>

    <link href="<?= base_url() ?>assets/img/logo.png" rel="icon">
    <link href="<?= base_url() ?>assets/css/styles.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/login.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="login-page">
    <div class="login-shell">
        <section class="login-brand">
            <img src="<?= base_url('assets/img/tirta.png') ?>" class="brand-watermark" alt="" aria-hidden="true">

            <div class="brand-top">
                <div class="brand-logo">
                    <img src="<?= base_url('assets/img/tirta.png') ?>" class="brand-mark" alt="Logo Perumdam Ijen Tirta">
                </div>
                <div class="brand-wordmark">
                    <span>Perumdam</span>
                    <span>Ijen Tirta</span>
                </div>
            </div>

            <div class="brand-copy">
                <p class="brand-eyebrow">Rencana Kerja dan Anggaran Perusahaan</p>
                <h1 class="brand-title">RKAP</h1>
                <p class="brand-desc">Sistem Digital Penyusunan Rencana Kerja dan Anggaran Perumdam Ijen Tirta.</p>
            </div>
        </section>

        <main class="login-panel">
            <div class="login-form-wrap">
                <header class="login-heading">
                    <h2>Silakan Log in</h2>
                    <p>Gunakan nama UPK atau bagian dan kata sandi yang terdaftar.</p>
                </header>

                <?php $info = $this->session->flashdata('info'); ?>
                <?php if ($info) : ?>
                    <div class="login-flash"><?= $info; ?></div>
                <?php endif; ?>
                <?= $this->session->unset_userdata('info'); ?>

                <form method="post" action="<?= base_url('auth') ?>" class="login-form">
                    <div class="field">
                        <label for="upk_bagian">Nama UPK / Bagian / Username</label>
                        <input type="text" name="upk_bagian" id="upk_bagian" value="<?= set_value('upk_bagian'); ?>" placeholder="Masukkan nama UPK atau bagian" autocomplete="username" autofocus>
                        <?= form_error('upk_bagian', '<span class="field-error">', '</span>'); ?>
                    </div>

                    <div class="field">
                        <label for="password">Kata Sandi</label>
                        <div class="password-wrap">
                            <input type="password" name="password" id="password" placeholder="Masukkan kata sandi" autocomplete="current-password">
                            <button type="button" class="pw-toggle" id="pwToggle" aria-label="Tampilkan kata sandi">
                                <i class="fa-solid fa-eye" id="pwIcon" aria-hidden="true"></i>
                            </button>
                        </div>
                        <?= form_error('password', '<span class="field-error">', '</span>'); ?>
                    </div>

                    <button type="submit" class="login-submit">
                        <span>Masuk</span>
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </button>
                </form>

                <hr class="login-rule">
            </div>

            <footer class="login-footer">
                Built With <span class="login-heart">&hearts;</span> by DIE Art'S Production 2022
            </footer>
        </main>
    </div>

    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
    <script>
        (function() {
            var input = document.getElementById('password');
            var toggle = document.getElementById('pwToggle');
            var icon = document.getElementById('pwIcon');

            toggle.addEventListener('click', function() {
                var show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                icon.classList.toggle('fa-eye', !show);
                icon.classList.toggle('fa-eye-slash', show);
                toggle.setAttribute('aria-label', show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
                input.focus();
            });
        })();
    </script>
</body>

</html>