<?php
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Prepare the SQL query to select the user by username
        $stmt = $pdo->prepare('SELECT UserId, Password FROM Users WHERE Username = :username AND Status = "Active" AND Role > 1');
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $this_id = $user['UserId'];
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $action = 'Login Attempt';
        $description = '';

        if ($user && password_verify($password, $user['Password'])) {
            echo "Login success!";

            // Log successful login attempt
            $description = 'Login successful for Admin ' . $username;

            // Insert login attempt into AuditLogs
            $stmt = $pdo->prepare('INSERT INTO AuditLogs (UserId, Action, IP_Address, Description) VALUES (:userId, :action, :ipAddress, :description)');
            $stmt->bindParam(':userId', $user['UserId']);
            $stmt->bindParam(':action', $action);
            $stmt->bindParam(':ipAddress', $ipAddress);
            $stmt->bindParam(':description', $description);
            $stmt->execute();

            // You can set session variables here for logged-in user
            session_start();
            $_SESSION['UserId'] = $user['UserId'];
            $_SESSION['Username'] = $username;
        } else if ($user && !password_verify($password, $user['Password'])) {
            $description = 'Login failed for Admin ' . $username;
            echo "Invalid username or password!";

            // Insert login attempt into AuditLogs
            $stmt = $pdo->prepare('INSERT INTO AuditLogs (UserId, Action, IP_Address, Description) VALUES (:userId, :action, :ipAddress, :description)');
            $stmt->bindParam(':userId', $this_id);
            $stmt->bindParam(':action', $action);
            $stmt->bindParam(':ipAddress', $ipAddress);
            $stmt->bindParam(':description', $description);
            $stmt->execute();
        } else {
            echo "Invalid username or password!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method!";
}
