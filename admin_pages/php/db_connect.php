<?php
// Database connection using PDO
$host = 'localhost';  // Change as per your database
$dbname = 'db_boa';  // Your database name
$username = 'shegnet_root';  // Your MySQL username
$password = 'Ku23@bun08@tu85';  // Your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: Could not connect to the database. " . $e->getMessage());
}
?>
