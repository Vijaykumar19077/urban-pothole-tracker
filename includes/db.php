<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$dbHost = getenv('DB_HOST');
$dbPort = getenv('DB_PORT') ?: '3306';
$dbName = getenv('DB_NAME') ?: 'defaultdb';
$dbUser = getenv('DB_USER');
$dbPass = getenv('DB_PASS');

try {
    $pdo = new PDO(
        "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_SSL_CA => '/etc/secrets/ca.pem',
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true
        ]
    );
} catch (PDOException $ex) {
    error_log($ex->getMessage());
    error_log('CA file exists: ' . (file_exists('/etc/secrets/ca.pem') ? 'YES' : 'NO'));
    error_log('CA file readable: ' . (is_readable('/etc/secrets/ca.pem') ? 'YES' : 'NO'));
    http_response_code(500);
    exit('Database connection failed. Check hosting configuration.');
}
