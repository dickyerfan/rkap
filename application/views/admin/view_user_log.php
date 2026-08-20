<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none;"><?= strtoupper($title) ?></a>
                </div>
                <div class="card-body">
                    <?php
                    // Helper nama bulan Indonesia
                    $bulan_ind = [
                        1 => 'Januari', 2 => 'Pebruari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                        7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'
                    ];

                    function tanggal_ind($dt, $bulan_ind)
                    {
                        $t = strtotime($dt);
                        return date('d', $t) . ' ' . $bulan_ind[(int)date('n', $t)] . ' ' . date('Y', $t);
                    }

                    function label_hari($tgl, $bulan_ind)
                    {
                        $today = date('Y-m-d');
                        $yesterday = date('Y-m-d', strtotime('-1 day'));
                        if ($tgl === $today) return 'Hari Ini';
                        if ($tgl === $yesterday) return 'Kemarin';
                        return tanggal_ind($tgl . ' 00:00:00', $bulan_ind);
                    }

                    function waktu_lalu($dt)
                    {
                        if (!$dt) return '-';
                        $diff = time() - strtotime($dt);
                        if ($diff < 0) $diff = 0;
                        if ($diff < 60) return 'Baru saja';
                        $m = floor($diff / 60);
                        if ($m < 60) return "$m menit lalu";
                        $h = floor($m / 60);
                        $mm = $m % 60;
                        if ($h < 24) return $mm > 0 ? "$h jam $mm mnt lalu" : "$h jam lalu";
                        return date('d-m-Y H:i', strtotime($dt));
                    }

                    function durasi_sesi($login, $logout)
                    {
                        if (!$logout) return '-';
                        $diff = strtotime($logout) - strtotime($login);
                        if ($diff < 0) $diff = 0;
                        $h = floor($diff / 3600);
                        $m = floor(($diff % 3600) / 60);
                        $s = $diff % 60;
                        if ($h > 0) return "{$h}j {$m}m";
                        if ($m > 0) return "{$m}m {$s}d";
                        return "{$s}d";
                    }

                    // Tab yang sedang aktif (after filter tetap di Riwayat Login)
                    $active_tab = isset($active_tab) ? $active_tab : 'online';

                    // Kelompokkan riwayat per tanggal (sudah urut DESC dari query)
                    $grouped_history = [];
                    foreach ($history as $h) {
                        $tgl = date('Y-m-d', strtotime($h['login_time']));
                        $grouped_history[$tgl][] = $h;
                    }
                    ?>
                    <!-- Ringkasan statistik -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="card text-white bg-success">
                                <div class="card-body py-2">
                                    <div class="row">
                                        <div class="col-8">
                                            <span style="font-size:0.8rem;">USER SEDANG ONLINE</span>
                                            <h4 class="mb-0" id="stat_online"><?= $stats['total_online'] ?></h4>
                                        </div>
                                        <div class="col-4 text-end">
                                            <i class="fas fa-user-check fa-2x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-info">
                                <div class="card-body py-2">
                                    <div class="row">
                                        <div class="col-8">
                                            <span style="font-size:0.8rem;">LOGIN HARI INI</span>
                                            <h4 class="mb-0" id="stat_login_hari_ini"><?= $stats['login_hari_ini'] ?></h4>
                                        </div>
                                        <div class="col-4 text-end">
                                            <i class="fas fa-sign-in-alt fa-2x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-secondary">
                                <div class="card-body py-2">
                                    <div class="row">
                                        <div class="col-8">
                                            <span style="font-size:0.8rem;">TOTAL USER AKTIF</span>
                                            <h4 class="mb-0"><?= $stats['total_user_aktif'] ?></h4>
                                        </div>
                                        <div class="col-4 text-end">
                                            <i class="fas fa-users fa-2x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?= $active_tab != 'history' ? 'active' : '' ?>" id="online-tab" data-bs-toggle="tab" data-bs-target="#online" type="button" role="tab" aria-controls="online" aria-selected="<?= $active_tab != 'history' ? 'true' : 'false' ?>">
                                <i class="fas fa-user-check"></i> User Online
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?= $active_tab == 'history' ? 'active' : '' ?>" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab" aria-controls="history" aria-selected="<?= $active_tab == 'history' ? 'true' : 'false' ?>">
                                <i class="fas fa-history"></i> Riwayat Login
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <!-- ========== TAB ONLINE ========== -->
                        <div class="tab-pane fade <?= $active_tab != 'history' ? 'show active' : '' ?>" id="online" role="tabpanel" aria-labelledby="online-tab">
                            <div class="table-responsive mt-2">
                                <table class="table table-sm table-bordered table-striped" style="font-size:0.8rem;" id="tabel_online">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>Nama Lengkap</th>
                                            <th>Level</th>
                                            <th>Tipe</th>
                                            <th>IP Address</th>
                                            <th>Aktif Terakhir</th>
                                            <th>Login Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($online_users)) : ?>
                                            <tr>
                                                <td colspan="8" class="text-center text-muted">Tidak ada user yang sedang online</td>
                                            </tr>
                                        <?php else : ?>
                                            <?php foreach ($online_users as $i => $u) : ?>
                                                <tr>
                                                    <td class="text-center"><?= $i + 1 ?></td>
                                                    <td><?= htmlspecialchars($u['username']) ?></td>
                                                    <td><?= htmlspecialchars($u['nama_lengkap']) ?></td>
                                                    <td><?= htmlspecialchars($u['level']) ?></td>
                                                    <td><?= htmlspecialchars($u['tipe']) ?></td>
                                                    <td><?= htmlspecialchars($u['ip_address']) ?></td>
                                                    <td><span class="badge bg-success"><?= waktu_lalu($u['last_activity']) ?></span></td>
                                                    <td><?= date('d-m-Y H:i:s', strtotime($u['login_time'])) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- ========== TAB RIWAYAT ========== -->
                        <div class="tab-pane fade <?= $active_tab == 'history' ? 'show active' : '' ?>" id="history" role="tabpanel" aria-labelledby="history-tab">
                            <!-- Filter tanggal -->
                            <form method="get" action="<?= base_url('admin/user_log') ?>" class="mt-2">
                                <input type="hidden" name="tab" value="history">
                                <div class="row g-2 align-items-end">
                                    <div class="col-auto">
                                        <label class="form-label mb-0" style="font-size:0.8rem;">Dari</label>
                                        <input type="date" name="dari" class="form-control form-control-sm" value="<?= htmlspecialchars($dari ?? '') ?>">
                                    </div>
                                    <div class="col-auto">
                                        <label class="form-label mb-0" style="font-size:0.8rem;">Sampai</label>
                                        <input type="date" name="sampai" class="form-control form-control-sm" value="<?= htmlspecialchars($sampai ?? '') ?>">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                                        <a href="<?= base_url('admin/user_log?tab=history') ?>" class="btn btn-sm btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>

                            <?php if (empty($grouped_history)) : ?>
                                <div class="alert alert-secondary mt-2 mb-0" style="font-size:0.8rem;">
                                    Belum ada riwayat login<?= ($dari || $sampai) ? ' pada rentang tanggal tersebut' : '' ?>.
                                </div>
                            <?php else : ?>
                                <?php foreach ($grouped_history as $tgl => $rows) : ?>
                                    <?php
                                    $jml_online = 0;
                                    $jml_logout = 0;
                                    foreach ($rows as $h) {
                                        if ($h['logout_time']) {
                                            $jml_logout++;
                                        } else {
                                            $jml_online++;
                                        }
                                    }
                                    // Default terbuka untuk Hari Ini & Kemarin; tanggal lain dikecilkan
                                    $today = date('Y-m-d');
                                    $yesterday = date('Y-m-d', strtotime('-1 day'));
                                    $is_recent = ($tgl === $today || $tgl === $yesterday);
                                    $collapse_id = 'hist_' . str_replace('-', '', $tgl);
                                    ?>
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-between align-items-center bg-light border rounded px-2 py-1">
                                            <button type="button" class="btn btn-link text-decoration-none p-0 fw-bold text-dark" style="font-size:0.85rem;" data-bs-toggle="collapse" data-bs-target="#<?= $collapse_id ?>" aria-expanded="<?= $is_recent ? 'true' : 'false' ?>">
                                                <i class="fas fa-chevron-<?= $is_recent ? 'down' : 'right' ?> me-1"></i>
                                                <?= label_hari($tgl, $bulan_ind) ?><?= $tgl == date('Y-m-d') ? ', ' . tanggal_ind($tgl, $bulan_ind) : '' ?>
                                            </button>
                                            <span class="text-muted" style="font-size:0.8rem;">
                                                <?= count($rows) ?> login | <?= $jml_logout ?> logout
                                            </span>
                                        </div>
                                        <div class="collapse hist-collapse <?= $is_recent ? 'show' : '' ?>" id="<?= $collapse_id ?>">
                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered table-striped" style="font-size:0.8rem;">
                                                    <thead class="table-light text-center">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Username</th>
                                                            <th>Nama Lengkap</th>
                                                            <th>Level</th>
                                                            <th>Tipe</th>
                                                            <th>IP Address</th>
                                                            <th>Login Time</th>
                                                            <th>Logout Time</th>
                                                            <th>Durasi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($rows as $i => $h) : ?>
                                                            <tr>
                                                                <td class="text-center"><?= $i + 1 ?></td>
                                                                <td><?= htmlspecialchars($h['username']) ?></td>
                                                                <td><?= htmlspecialchars($h['nama_lengkap']) ?></td>
                                                                <td><?= htmlspecialchars($h['level']) ?></td>
                                                                <td><?= htmlspecialchars($h['tipe']) ?></td>
                                                                <td><?= htmlspecialchars($h['ip_address']) ?></td>
                                                                <td><?= date('d-m-Y H:i:s', strtotime($h['login_time'])) ?></td>
                                                                <td class="text-center">
                                                                    <?php if ($h['logout_time']) : ?>
                                                                        <?= date('d-m-Y H:i:s', strtotime($h['logout_time'])) ?>
                                                                    <?php else : ?>
                                                                        <span class="badge bg-success">Online</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td><?= durasi_sesi($h['login_time'], $h['logout_time']) ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // ===== Auto-refresh data online setiap 20 detik via AJAX =====
        setInterval(function() {
            fetch("<?= base_url('admin/user_log/get_online') ?>")
                .then(res => res.json())
                .then(data => {
                    if (!data.success) return;

                    // Update statistik
                    document.getElementById('stat_online').textContent = data.stats.total_online;
                    document.getElementById('stat_login_hari_ini').textContent = data.stats.login_hari_ini;

                    // Update tabel online
                    let tbody = document.querySelector('#tabel_online tbody');
                    if (data.online.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted">Tidak ada user yang sedang online</td></tr>';
                    } else {
                        let html = '';
                        data.online.forEach((u, i) => {
                            html += `<tr>
                                <td class="text-center">${i + 1}</td>
                                <td>${escapeHtml(u.username)}</td>
                                <td>${escapeHtml(u.nama_lengkap)}</td>
                                <td>${escapeHtml(u.level)}</td>
                                <td>${escapeHtml(u.tipe)}</td>
                                <td>${escapeHtml(u.ip_address)}</td>
                                <td><span class="badge bg-success">${waktuLalu(u.last_activity)}</span></td>
                                <td>${formatDateTime(u.login_time)}</td>
                            </tr>`;
                        });
                        tbody.innerHTML = html;
                    }
                })
                .catch(err => console.error('Gagal refresh data online:', err));
        }, 20000);

        // Helper escape HTML
        function escapeHtml(str) {
            if (!str) return '';
            const div = document.createElement('div');
            div.textContent = String(str);
            return div.innerHTML;
        }

        // Helper format tanggal
        function formatDateTime(str) {
            if (!str) return '-';
            const d = new Date(String(str).replace(' ', 'T'));
            const pad = n => String(n).padStart(2, '0');
            return `${pad(d.getDate())}-${pad(d.getMonth() + 1)}-${d.getFullYear()} ${pad(d.getHours())}:${pad(d.getMinutes())}:${pad(d.getSeconds())}`;
        }

        // Helper waktu relatif (mis. "3 menit lalu")
        function waktuLalu(str) {
            if (!str) return '-';
            const t = new Date(String(str).replace(' ', 'T')).getTime();
            const diff = Math.floor((Date.now() - t) / 1000);
            if (diff < 60) return 'Baru saja';
            const m = Math.floor(diff / 60);
            if (m < 60) return m + ' menit lalu';
            const h = Math.floor(m / 60);
            const mm = m % 60;
            if (h < 24) return mm > 0 ? `${h} jam ${mm} mnt lalu` : `${h} jam lalu`;
            return formatDateTime(str);
        }

        // Ganti ikon chevron saat grup tanggal dibuka/ditutup
        document.querySelectorAll('.hist-collapse').forEach(el => {
            el.addEventListener('show.bs.collapse', function() {
                let chev = this.parentElement.querySelector('.fa-chevron-right, .fa-chevron-down');
                if (chev) chev.className = 'fas fa-chevron-down me-1';
            });
            el.addEventListener('hide.bs.collapse', function() {
                let chev = this.parentElement.querySelector('.fa-chevron-right, .fa-chevron-down');
                if (chev) chev.className = 'fas fa-chevron-right me-1';
            });
        });
    </script>