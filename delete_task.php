<?php
require 'config.php';
$id = $_GET['id'];
$pdo->prepare("DELETE FROM scheduled_tasks WHERE id = ?")->execute([$id]);
header('Location: index.php');
exit; 