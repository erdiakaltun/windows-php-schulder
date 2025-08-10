<?php
require 'config.php';
$id = $_GET['id'];
$task = $pdo->query("SELECT * FROM scheduled_tasks WHERE id = $id")->fetch();
if ($task) {
    $pdo->prepare("UPDATE scheduled_tasks SET is_active = NOT is_active WHERE id = ?")->execute([$id]);
}
header('Location: index.php');
exit; 