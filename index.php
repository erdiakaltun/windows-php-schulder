<?php
require 'config.php';
$tasks = $pdo->query("SELECT * FROM scheduled_tasks")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Zamanlanmış Görevler</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h1>Zamanlanmış Görevler</h1>
    <a href="add_task.php" class="btn btn-success mb-3">Yeni Görev Ekle</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ad</th>
                <th>Script</th>
                <th>Aralık</th>
                <th>Son Çalışma</th>
                <th>Çalışma Sayısı</th>
                <th>Durum</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?=htmlspecialchars($task['name'])?></td>
                <td><?=htmlspecialchars($task['script_path'])?></td>
                <td>
                    <?php
                    switch ($task['interval_type']) {
                        case 'minute': echo $task['interval_value'] . " dk'da bir"; break;
                        case 'hour': echo $task['interval_value'] . " saatte bir"; break;
                        case 'day': echo $task['interval_value'] . " günde bir"; break;
                        case 'custom': echo "Günde {$task['interval_value']} defa"; break;
                    }
                    ?>
                </td>
                <td><?=$task['last_run']?></td>
                <td><?=$task['run_count']?></td>
                <td>
                    <?php if ($task['is_active']): ?>
                        <span class="badge bg-success">Aktif</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Pasif</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="edit_task.php?id=<?=$task['id']?>" class="btn btn-sm btn-primary">Düzenle</a>
                    <a href="toggle_task.php?id=<?=$task['id']?>" class="btn btn-sm btn-warning">
                        <?=$task['is_active'] ? 'Durdur' : 'Başlat'?>
                    </a>
                    <a href="delete_task.php?id=<?=$task['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Silinsin mi?')">Sil</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html> 