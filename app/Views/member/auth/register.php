<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Form Registrasi</h2>

     <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red;"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif ?>

    <form method="post" action="<?= base_url('/register') ?>">
        <?= csrf_field() ?>

        <label>Nama</label><br>
        <input type="text" name="name" value="<?= old('name') ?>"><br><br>

        <label>Email</label><br>
        <input type="email" name="email" value="<?= old('email') ?>"><br><br>

        <label>Password</label><br>
        <input type="password" name="password"><br><br>

        <label>Konfirmasi Password</label><br>
        <input type="password" name="confirm_password"><br><br>

        <button type="submit">Daftar</button>
    </form>

    <hr>

    <form action="<?= base_url('/auth/google-login') ?>" method="get">
        <button type="submit" style="background:#4285F4; color:white; padding:10px 20px; border:none; cursor:pointer;">
            Login dengan Google
        </button>
    </form>
    <p>Sudah punya akun? <a href="<?=base_url('/login') ?>">Login</a></p>
</body>
</html>
