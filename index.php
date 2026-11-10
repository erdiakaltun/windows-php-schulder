<?php
require 'config.php';
require_admin();
$tasks = $pdo->query('SELECT * FROM scheduled_tasks')->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Zamanlanmış Görevler</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
</head>
<body class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Zamanlanmış Görevler</h1>
        <form method="post" action="logout.php">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
            <button type="submit" class="btn btn-outline-secondary">Çıkış yap</button>
        </form>
    </div>
    <a href="add_task.php" class="btn btn-success mb-3">Yeni Görev Ekle</a>
    <table class="table table-bordered">
        <thead>
            <tr><th>Ad</th><th>Script</th><th>Aralık</th><th>Son Çalışma</th><th>Çalışma Sayısı</th><th>Durum</th><th>İşlem</th></tr>
        </thead>
        <tbody>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?= htmlspecialchars($task['name'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($task['script_path'], ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <?php
                    switch ($task['interval_type']) {
                        case 'minute': echo (int) $task['interval_value'] . " dk'da bir"; break;
                        case 'hour': echo (int) $task['interval_value'] . " saatte bir"; break;
                        case 'day': echo (int) $task['interval_value'] . " günde bir"; break;
                        case 'custom': echo 'Günde ' . (int) $task['interval_value'] . ' defa'; break;
                    }
                    ?>
                </td>
                <td><?= htmlspecialchars((string) $task['last_run'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= (int) $task['run_count'] ?></td>
                <td><?= $task['is_active'] ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Pasif</span>' ?></td>
                <td class="d-flex gap-1">
                    <a href="edit_task.php?id=<?= (int) $task['id'] ?>" class="btn btn-sm btn-primary">Düzenle</a>
                    <form method="post" action="toggle_task.php">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="id" value="<?= (int) $task['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-warning"><?= $task['is_active'] ? 'Durdur' : 'Başlat' ?></button>
                    </form>
                    <form method="post" action="delete_task.php" onsubmit="return confirm('Silinsin mi?')">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="id" value="<?= (int) $task['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Sil</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>