<?php
require 'config.php';
$id = $_GET['id'];
$task = $pdo->query("SELECT * FROM scheduled_tasks WHERE id = $id")->fetch();
if (!$task) die("Görev bulunamadı.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE scheduled_tasks SET name=?, script_path=?, interval_type=?, interval_value=? WHERE id=?");
    $stmt->execute([
        $_POST['name'],
        $_POST['script_path'],
        $_POST['interval_type'],
        $_POST['interval_value'],
        $id
    ]);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Görev Düzenle</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h1>Görev Düzenle</h1>
    <form method="post">
        <div class="mb-3">
            <label>Ad</label>
            <input type="text" name="name" class="form-control" value="<?=htmlspecialchars($task['name'])?>" required>
        </div>
        <div class="mb-3">
            <label>Script (scripts/ klasöründeki dosya adı)</label>
            <input type="text" name="script_path" class="form-control" value="<?=htmlspecialchars($task['script_path'])?>" required>
        </div>
        <div class="mb-3">
            <label>Aralık Tipi</label>
            <select name="interval_type" class="form-control" required>
                <option value="minute" <?=$task['interval_type']=='minute'?'selected':''?>>Dakika</option>
                <option value="hour" <?=$task['interval_type']=='hour'?'selected':''?>>Saat</option>
                <option value="day" <?=$task['interval_type']=='day'?'selected':''?>>Gün</option>
                <option value="custom" <?=$task['interval_type']=='custom'?'selected':''?>>Günde X Defa</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Aralık Değeri</label>
            <input type="number" name="interval_value" class="form-control" value="<?=$task['interval_value']?>" required>
        </div>
        <button class="btn btn-primary">Güncelle</button>
        <a href="index.php" class="btn btn-secondary">Geri</a>
    </form>
</body>
</html> 