<?php
require 'config.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_valid_csrf_token();

    $name = trim($_POST['name'] ?? '');
    $scriptPath = trim($_POST['script_path'] ?? '');
    $intervalType = $_POST['interval_type'] ?? '';
    $intervalValue = filter_input(INPUT_POST, 'interval_value', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

    if ($name === '' || $scriptPath === '' || !in_array($intervalType, ['minute', 'hour', 'day', 'custom'], true) || $intervalValue === false || $intervalValue === null) {
        http_response_code(400);
        exit('Görev bilgileri geçersiz.');
    }
    $scriptPath = resolve_allowed_task_script($scriptPath);
    if ($scriptPath === false) {
        http_response_code(400);
        exit('Yalnızca mevcut PHP dosyaları scripts/ klasöründen seçilebilir.');
    }

    $stmt = $pdo->prepare('INSERT INTO scheduled_tasks (name, script_path, interval_type, interval_value) VALUES (?, ?, ?, ?)');
    $stmt->execute([$name, $scriptPath, $intervalType, $intervalValue]);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Görev Ekle</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h1>Yeni Görev Ekle</h1>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?=htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8')?>">
        <div class="mb-3">
            <label>Ad</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Script Dosya Yolu (tam yol)</label>
            <input type="text" name="script_path" id="script_path" class="form-control" placeholder="C:\\wamp64\\www\\schulder\\scripts\\test.php" required>
            <small class="text-muted">Tam dosya yolunu elle girmeniz gerekmektedir.</small>
        </div>
        <div class="mb-3">
            <label>Aralık Tipi</label>
            <select name="interval_type" class="form-control" required>
                <option value="minute">Dakika</option>
                <option value="hour">Saat</option>
                <option value="day">Gün</option>
                <option value="custom">Günde X Defa</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Aralık Değeri</label>
            <input type="number" name="interval_value" class="form-control" min="1" required>
        </div>
        <button class="btn btn-success">Kaydet</button>
        <a href="index.php" class="btn btn-secondary">Geri</a>
    </form>
</body>
</html>