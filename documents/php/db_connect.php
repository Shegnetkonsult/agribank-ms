<?php
$dsn = 'mysql:host=localhost;dbname=db_boa';
$username = 'shegnet_root';
$password = 'Ku23@bun08@tu85';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}
?>
