<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <div class="dashboard">
        <h1>Selamat Datang di Dashboard</h1>
        <p>Halo, <?= session('email'); ?>! Kamu berhasil login.</p>
        <p><a href="<?= base_url('logout') ?>">Logout</a></p>

        <ul>
            <li><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
            <li><a href="<?= base_url('list-buku') ?>">List Buku</a></li>
            <li><a href="<?= base_url('dashboard') ?>">Peminjaman</a></li>
            <li><a href="<?= base_url('dashboard') ?>">Profile</a></li>
        </ul>
    </div>
</body>
</html>
