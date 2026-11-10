<?php
require_once __DIR__ . '/auth.php';

if (($_SESSION['admin_authenticated'] ?? false) === true) {
    header('Location: index.php');
    exit;
}

$passwordHash = getenv('SCHULDER_ADMIN_PASSWORD_HASH');
if (!$passwordHash) {
    http_response_code(503);
    exit('Yönetici parolası yapılandırılmamış. SCHULDER_ADMIN_PASSWORD_HASH ortam değişkenini ayarlayın.');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_valid_csrf_token();
    $password = $_POST['password'] ?? '';

    if (is_string($password) && password_verify($password, $passwordHash)) {
        session_regenerate_id(true);
        $_SESSION['admin_authenticated'] = true;
        header('Location: index.php');
        exit;
    }

    $error = 'Parola hatalı.';
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Yönetici Girişi</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
</head>
<body class="container mt-5" style="max-width: 480px;">
    <h1>Yönetici Girişi</h1>
    <?php if ($error !== ''): ?>
        <div class="alert alert-danger"><?=htmlspecialchars($error, ENT_QUOTES, 'UTF-8')?></div>
    <?php endif; ?>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?=htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8')?>">
        <div class="mb-3">
            <label for="password" class="form-label">Parola</label>
            <input id="password" type="password" name="password" class="form-control" autocomplete="current-password" required autofocus>
        </div>
        <button type="submit" class="btn btn-primary">Giriş yap</button>
    </form>
</body>
</html>
