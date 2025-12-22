<?php
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $nationalID = $_POST['nationalID'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $passport = null;
    if (isset($_FILES['passport']) && $_FILES['passport']['error'] == 0) {
        $passport = file_get_contents($_FILES['passport']['tmp_name']);
    }

    try {
        // Check if NationalID or any other unique field already exists
        $checkStmt = $pdo->prepare('SELECT COUNT(*) FROM Users WHERE NationalID = :nationalID');
        $checkStmt->bindParam(':nationalID', $nationalID);
        $checkStmt->execute();
        $existing = $checkStmt->fetchColumn();

        if ($existing > 0) {
            // If the NationalID already exists, return an error message
            echo "Error: National ID already exists. Please enter a different one.";
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
            echo "Account created successfully!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request!";
}
