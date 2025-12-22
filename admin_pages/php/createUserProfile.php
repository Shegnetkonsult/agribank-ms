<?php
session_start(); // Start the session

require_once 'db_connect.php';

// Ensure the user is logged in
if (!isset($_SESSION['UserId'])) {
    echo '<div class="alert alert-danger">You have been automatically logged out, Please Log in again to proceed.</div>';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['Username'];
    $fullName = $_POST['FullName'];
    $email = $_POST['Email'];
    $phoneNumber = $_POST['PhoneNumber'];
    $nationalID = $_POST['NationalID'];
    $address = $_POST['Address'];
    $password = password_hash($_POST['Password'], PASSWORD_BCRYPT);

    $passport = null;
    if (isset($_FILES['Passport']) && $_FILES['Passport']['error'] == 0) {
        $passport = file_get_contents($_FILES['Passport']['tmp_name']);
    }

    try {
        // Check if NationalID or any other unique field already exists
        $checkStmt = $pdo->prepare('SELECT COUNT(*) FROM Users WHERE NationalID = :nationalID');
        //$checkStmt->bindParam(':username', $username);
        $checkStmt->bindParam(':nationalID', $nationalID);
        $existing = $checkStmt->fetchColumn();

        if ($existing > 0) {
            // If the NationalID already exists, return an error message
            echo "Error: Username already exists or National ID has been assigned to an existing user. Please enter a different username or cross check National ID inputs.";
        } else {
            // If unique value is valid, insert the new user record
            $stmt = $pdo->prepare('INSERT INTO Users (Username, FullName, Email, PhoneNumber, NationalID, Passport, Address, Password, Role, Created_At, Status)
                                    VALUES (:username, :fullName, :email, :phoneNumber, :nationalID, :passport, :address, :password, 1, NOW(), "Active")');
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':fullName', $fullName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phoneNumber', $phoneNumber);
            $stmt->bindParam(':nationalID', $nationalID);
            $stmt->bindParam(':passport', $passport, PDO::PARAM_LOB);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':password', $password);
            $stmt->execute();

            // Log the action
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            $action = 'User Created by: '. $_SESSION['UserId'];
            $description = "A new user ($username: $fullName) has been created now :NOW()";
            $adminUserId = $_SESSION['UserId'];
            $_SESSION['the_user_name'] = $username;

            $stmt = $pdo->prepare('INSERT INTO AuditLogs (UserId, Action, IP_Address, Description) VALUES (:adminUserId, :action, :ipAddress, :description)');
            $stmt->bindParam(':adminUserId', $adminUserId);
            $stmt->bindParam(':action', $action);
            $stmt->bindParam(':ipAddress', $ipAddress);
            $stmt->bindParam(':description', $description);
            $stmt->execute();

            echo "User created successfully with UserName($username). Use this in other section of program!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request!";
}
