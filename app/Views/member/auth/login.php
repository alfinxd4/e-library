<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Form Login</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red;"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif ?>

    <form method="post" action="<?= base_url('/login') ?>">
        <?= csrf_field() ?>

        <label>Email</label><br>
        <input type="email" name="email" value="<?= old('email') ?>"><br><br>

        <label>Password</label><br>
        <input type="password" name="password"><br><br>

        <button type="submit">Login</button>
    </form>

    <hr>

    <form action="<?= base_url('/auth/google-login') ?>" method="get">
        <button type="submit" style="background:#4285F4; color:white; padding:10px 20px; border:none; cursor:pointer;">
            Login dengan Google
        </button>
    </form>
    <p>Belum punya akun? <a href="<?=base_url('/register') ?>">Register</a></p>

</body>
</html>
