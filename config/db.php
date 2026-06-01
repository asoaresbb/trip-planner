<?php
// Ligação à base de dados via PDO.
$config = require __DIR__ . '/credentials.php';

$dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $config['user'], $config['pass'], [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    exit('Erro de ligação à base de dados.');
}

return $pdo;
