<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - OneAtATime</title>
</head>
<body>
    <h2>Admin Login</h2>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <?= !empty($validation_errors) ? $validation_errors : '' ?>

    <form method="post" action="<?= site_url('adminauth/login') ?>">
        <input type="text" name="name" placeholder="Admin Name" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
