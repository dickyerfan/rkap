<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none;"><?= strtoupper($title) ?></a>
                </div>
                <div class="card-body">
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
                            <button class="nav-link active" id="online-tab" data-bs-toggle="tab" data-bs-target="#online" type="button" role="tab" aria-controls="online" aria-selected="true">
                                <i class="fas fa-user-check"></i> User Online
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab" aria-controls="history" aria-selected="false">
                                <i class="fas fa-history"></i> Riwayat Login
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <!-- ========== TAB ONLINE ========== -->
                        <div class="tab-pane fade show active" id="online" role="tabpanel" aria-labelledby="online-tab">
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
                                            <th>Login Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($online_users)) : ?>
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">Tidak ada user yang sedang online</td>
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
                                                    <td><?= date('d-m-Y H:i:s', strtotime($u['login_time'])) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- ========== TAB RIWAYAT ========== -->
                        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                            <div class="table-responsive mt-2">
                                <table class="table table-sm table-bordered table-striped" style="font-size:0.8rem;" id="tabel_history">
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($history)) : ?>
                                            <tr>
                                                <td colspan="8" class="text-center text-muted">Belum ada riwayat login</td>
                                            </tr>
                                        <?php else : ?>
                                            <?php foreach ($history as $i => $h) : ?>
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
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // ===== Auto-refresh data online setiap 30 detik via AJAX =====
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
                        tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted">Tidak ada user yang sedang online</td></tr>';
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
                                <td>${formatDateTime(u.login_time)}</td>
                            </tr>`;
                        });
                        tbody.innerHTML = html;
                    }
                })
                .catch(err => console.error('Gagal refresh data online:', err));
        }, 30000);

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
            const d = new Date(str);
            const pad = n => String(n).padStart(2, '0');
            return `${pad(d.getDate())}-${pad(d.getMonth() + 1)}-${d.getFullYear()} ${pad(d.getHours())}:${pad(d.getMinutes())}:${pad(d.getSeconds())}`;
        }
    </script>
