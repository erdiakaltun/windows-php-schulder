<?php
require_once __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Method not allowed');
}
require_valid_csrf_token();

unset($_SESSION['admin_authenticated']);
session_regenerate_id(true);

header('Location: login.php');
exit;
