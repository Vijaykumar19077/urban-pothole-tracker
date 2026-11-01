<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$dbHost = 'localhost';
$dbName = 'urban_tracker';
$dbUser = 'root';
$dbPass = ''; // Default XAMPP MySQL password is usually blank. Change if you set one.

try {
    $pdo = new PDO(
        "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4",
        $dbUser,
        $dbPass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
         PDO::ATTR_EMULATE_PREPARES => false]
    );
} catch (PDOException $ex) {
    http_response_code(500);
    exit('Database connection failed. Check includes/db.php and confirm MySQL is running. Details: ' . htmlspecialchars($ex->getMessage()));
}
