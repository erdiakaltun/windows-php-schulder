<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
file_put_contents(__DIR__.'/cron_debug.log', date('Y-m-d H:i:s')." cron_runner.php çalıştı\n", FILE_APPEND);
require 'config.php';

$now = new DateTime();

$stmt = $pdo->query("SELECT * FROM scheduled_tasks WHERE is_active = 1");
$tasks = $stmt->fetchAll();

foreach ($tasks as $task) {
    $shouldRun = false;
    $lastRun = $task['last_run'] ? new DateTime($task['last_run']) : null;
    $nextRun = $lastRun ? (clone $lastRun) : null;

    switch ($task['interval_type']) {
        case 'minute':
            if (!$nextRun || $nextRun->modify("+{$task['interval_value']} minutes") <= $now) $shouldRun = true;
            break;
        case 'hour':
            if (!$nextRun || $nextRun->modify("+{$task['interval_value']} hours") <= $now) $shouldRun = true;
            break;
        case 'day':
            if (!$nextRun || $nextRun->modify("+{$task['interval_value']} days") <= $now) $shouldRun = true;
            break;
        case 'custom':
            $interval = 24 / $task['interval_value'];
            if (!$nextRun || $nextRun->modify("+{$interval} hours") <= $now) $shouldRun = true;
            break;
    }

    if ($shouldRun) {
        $script = $task['script_path'];
        if (!preg_match('/^([a-zA-Z]:\\\\|\/)/', $script)) {
            // Göreli yol ise proje kökünden başlat
            $script = __DIR__ . '/' . ltrim($script, '/\\');
        }
        if (file_exists($script)) {
            $cmd = "C:\\wamp64\\bin\\php\\php8.2.18\\php.exe \"$script\"";
            $output = shell_exec($cmd . ' 2>&1');
            file_put_contents(__DIR__.'/cron_debug.log', "Komut: $cmd\nÇıktı: $output\n", FILE_APPEND);
            $pdo->prepare("UPDATE scheduled_tasks SET last_run = ?, run_count = run_count + 1 WHERE id = ?")
                ->execute([$now->format('Y-m-d H:i:s'), $task['id']]);
        } else {
            file_put_contents(__DIR__.'/cron_debug.log', "Script bulunamadı: $script\n", FILE_APPEND);
        }
    }
} 

