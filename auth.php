<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function require_valid_csrf_token(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || !hash_equals(csrf_token(), $token)) {
        http_response_code(403);
        exit('Geçersiz istek doğrulaması.');
    }
}

function require_admin(): void
{
    if (($_SESSION['admin_authenticated'] ?? false) !== true) {
        header('Location: login.php');
        exit;
    }
}
