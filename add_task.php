<?php
require 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $script_path = $_POST['script_path'];
    // Tam yol doğrulaması: Dosya gerçekten var mı?
    if (!file_exists($script_path)) {
        die('Seçilen script dosyası bulunamadı: ' . htmlspecialchars($script_path));
    }
    $stmt = $pdo->prepare("INSERT INTO scheduled_tasks (name, script_path, interval_type, interval_value) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $_POST['name'],
        $script_path,
        $_POST['interval_type'],
        $_POST['interval_value']
    ]);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Görev Ekle</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <script>
    function updateScriptPath(input) {
        if (input.files.length > 0) {
            // Tam dosya yolunu al (sadece dosya adını alabiliriz, tam yol güvenlik nedeniyle browserdan alınamaz)
            // Kullanıcıdan manuel olarak tam yol girmesini isteyeceğiz
            document.getElementById('script_path').value = input.value;
        }
    }
    </script>
</head>
<body class="container mt-4">
    <h1>Yeni Görev Ekle</h1>
    <form method="post">
        <div class="mb-3">
            <label>Ad</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Script Dosya Yolu (tam yol)</label>
            <div class="input-group">
                <input type="text" name="script_path" id="script_path" class="form-control" placeholder="C:\\wamp64\\www\\schulder\\scripts\\test.php" required>
            </div>
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
            <input type="number" name="interval_value" class="form-control" required>
        </div>
        <button class="btn btn-success">Kaydet</button>
        <a href="index.php" class="btn btn-secondary">Geri</a>
    </form>
</body>
</html> 