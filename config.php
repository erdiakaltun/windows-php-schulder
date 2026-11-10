<?php
require_once __DIR__ . '/auth.php';
function resolve_allowed_task_script(string $path)
{
    $scriptsDirectory = realpath(__DIR__ . DIRECTORY_SEPARATOR . 'scripts');
    $scriptPath = realpath($path);
    if ($scriptsDirectory === false || $scriptPath === false || !is_file($scriptPath) || strtolower(pathinfo($scriptPath, PATHINFO_EXTENSION)) !== 'php') {
        return false;
    }

    $prefix = rtrim($scriptsDirectory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    $caseInsensitive = DIRECTORY_SEPARATOR === '\\';
    $insideScriptsDirectory = $caseInsensitive
        ? strncasecmp($scriptPath, $prefix, strlen($prefix)) === 0
        : strncmp($scriptPath, $prefix, strlen($prefix)) === 0;

    return $insideScriptsDirectory ? $scriptPath : false;
}


$host = 'localhost';
$db   = '';
$user = '';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
}
