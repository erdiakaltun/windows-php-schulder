<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Method not allowed');
}
require_valid_csrf_token();

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if ($id === false || $id === null) {
    http_response_code(400);
    exit('Geçersiz görev kimliği.');
}

$stmt = $pdo->prepare('UPDATE scheduled_tasks SET is_active = NOT is_active WHERE id = ?');
$stmt->execute([$id]);

header('Location: index.php');
exit;
?>