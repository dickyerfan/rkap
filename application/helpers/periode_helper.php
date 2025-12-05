<?php

function can_input($nama_pengguna, $level, $status, $tahun_data)
{
    $tahun_rkap = date('Y') + 1;
    // SUPER ADMIN (username)
    if ($nama_pengguna === 'administrator') return true;

    // AUTO LOCK: Jika data tahun sebelumnya => Kunci edit
    if ($tahun_data < $tahun_rkap) {
        return false; // tidak bisa edit
    }

    // STATUS : Dibuka untuk Pengguna
    if ($status === 'dibuka_pengguna') {
        return true; // admin & pengguna boleh
    }

    // STATUS : Dibuka untuk Admin
    if ($status === 'dibuka_admin') {
        return ($level === 'Admin'); // hanya admin (kolom level) boleh
    }

    // STATUS : Ditutup
    if ($status === 'ditutup') {
        return false; // semua tidak boleh (kecuali administrator)
    }

    return false;
}

function can_generate($nama_pengguna, $level, $status, $tahun_data)
{
    $tahun_rkap = date('Y') + 1;
    // SUPER ADMIN (username)
    if ($nama_pengguna === 'administrator') return true;

    // AUTO LOCK: Jika data tahun sebelumnya => Kunci edit
    if ($tahun_data < $tahun_rkap) {
        return false; // tidak bisa edit
    }

    // Dibuka untuk pengguna -> hanya Admin (level == 'Admin') boleh generate
    if ($status === 'dibuka_pengguna') {
        return ($level === 'Admin');
    }

    // Dibuka untuk admin -> sekarang Anda minta Admin juga bisa generate => izinkan
    if ($status === 'dibuka_admin') {
        return ($level === 'Admin'); // Admin boleh generate juga
    }

    // Ditutup -> tidak boleh kecuali super admin (di atas)
    if ($status === 'ditutup') {
        return false;
    }

    return false;
}
