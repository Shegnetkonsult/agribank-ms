<?php
session_start(); // Start the session

// Ensure the user is logged in
if (!isset($_SESSION['UserId'])) {
    echo '<div class="alert alert-danger">You must be logged in to create an account.</div>';
    exit();
}

// Include the database connection
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get UserID from Username session variable
    if (isset($_SESSION['the_user_name'])) $the_user_name = $_SESSION['the_user_name'];
    else if (isset($_POST['username'])) $the_user_name = $_POST['username'];
    $sql = "SELECT UserId FROM Users WHERE Username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$the_user_name]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) $userId = $user['UserId']; //If username found
    else{
        // If username not exists
        echo '<div class="alert alert-info">User Not Found, Please verify userName. </div>';
        exit();
    }

    // Check if the user already has an account
    $sql = "SELECT AccountNumber FROM Accounts WHERE UserID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
    $existingAccount = $stmt->fetchColumn();

    if ($existingAccount) {
        // If an account already exists
        echo '<div class="alert alert-info">You already have an account. Your account number is: ' . htmlspecialchars($existingAccount) . '</div>';
        exit();
    }

    // Function to generate a unique 10-digit account number
    function generateAccountNumber($pdo) {
        while (true) {
            $accountNumber = sprintf('%010d', mt_rand(0, 9999999999)); // Generate a 10-digit number
            // Check if the account number already exists in the database
            $sql = "SELECT COUNT(*) FROM Accounts WHERE AccountNumber = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$accountNumber]);
            $count = $stmt->fetchColumn();

            if ($count == 0) {
                return $accountNumber; // Return if account number is unique
            }
        }
    }

    // Generate a unique account number
    $accountNumber = generateAccountNumber($pdo);
    $accountType = $_POST['accountType'];
    $bvn = $_POST['bvn'];

    // Prepare the SQL query
    $sql = "INSERT INTO Accounts (UserID, AccountNumber, bvn, AccountType, Balance, DateCreated, Status)
            VALUES (?, ?, ?, ?, '0.00', NOW(), 'Active')";

    // Prepare statement
    $stmt = $pdo->prepare($sql);

    // Execute statement
    if ($stmt->execute([$userId, $accountNumber, $bvn, $accountType])) {
        echo '<div class="alert alert-success">Account created successfully! Account Number: ' . htmlspecialchars($accountNumber) . '</div>';
    } else {
        echo '<div class="alert alert-danger">Error creating account: ' . htmlspecialchars($stmt->errorInfo()[2]) . '</div>';
    }
}
?>
