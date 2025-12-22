<?php
// Include the database connection
require_once 'db_connect.php';
require_once 'functions.php';
session_start(); // Start the session

// Ensure the user is logged in
if (!isset($_SESSION['UserId'])) {
    echo '<div class="alert alert-danger">You must be logged in to create an account.</div>';
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $depositAmount = $_POST['depositAmount'];
    $ownerAccountNo = $_SESSION['owner_account_no'];
    $ownerUserId = $_SESSION['owner_user_id'];
    $adminUserId = $_SESSION['UserId'];  // Assuming the admin user ID is also stored in session

    try {
        // Start a transaction
        $pdo->beginTransaction();

        // Fetch current balance
        $stmt = $pdo->prepare('SELECT Balance, AccountId FROM Accounts WHERE AccountNumber = :ownerAccountNo');
        $stmt->bindParam(':ownerAccountNo', $ownerAccountNo);
        $stmt->execute();
        $account = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($account) {
            $balanceBefore = $account['Balance'];
            $balanceAfter = $balanceBefore + $depositAmount;
            $accountId = $account['AccountId'];

            // Update the account balance
            $stmt = $pdo->prepare('UPDATE Accounts SET Balance = :balanceAfter WHERE AccountNumber = :ownerAccountNo');
            $stmt->bindParam(':balanceAfter', $balanceAfter);
            $stmt->bindParam(':ownerAccountNo', $ownerAccountNo);
            $stmt->execute();

            // Record the transaction
            $stmt = $pdo->prepare('INSERT INTO Transactions (AccountID, TransactionType, Amount, Date, Status, Balance_Before, Balance_After, Description)
                                   VALUES (:accountId, "Deposit", :depositAmount, Now(), "Completed", :balanceBefore, :balanceAfter, "Deposit by Admin")');
            $stmt->bindParam(':accountId', $accountId);
            $stmt->bindParam(':depositAmount', $depositAmount);
            $stmt->bindParam(':balanceBefore', $balanceBefore);
            $stmt->bindParam(':balanceAfter', $balanceAfter);
            $stmt->execute();

            // Log the admin action
            $action = 'Deposit';
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            $description = "Admin recorded a deposit of ". formatAsNaira($depositAmount). " on account: $ownerAccountNo";

            $stmt = $pdo->prepare('INSERT INTO AuditLogs (UserId, Action, IP_Address, Description) VALUES (:adminUserId, :action, :ipAddress, :description)');
            $stmt->bindParam(':adminUserId', $adminUserId);
            $stmt->bindParam(':action', $action);
            $stmt->bindParam(':ipAddress', $ipAddress);
            $stmt->bindParam(':description', $description);
            $stmt->execute();

            // Commit the transaction
            $pdo->commit();

            echo "Deposit recorded successfully!";
        } else {
            echo "Account not found!";
        }
    } catch (PDOException $e) {
        // Rollback the transaction in case of error
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method!";
}
?>
