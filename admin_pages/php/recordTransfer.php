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
    $transferAmount = $_POST['transferAmount'];
    $ownerAccountNo = $_SESSION['owner_account_no'];
    $ownerUserId = $_SESSION['owner_user_id'];
    $beneficiaryAccountNo = $_SESSION['beneficiary_account_no'];
    $beneficiaryUserId = $_SESSION['beneficiary_user_id'];
    $adminUserId = $_SESSION['UserId'];  // Assuming the admin user ID is also stored in session

    try {
        // Start a transaction
        $pdo->beginTransaction();

        // Fetch current balances
        $stmt = $pdo->prepare('SELECT AccountId, Balance FROM Accounts WHERE AccountNumber = :accountNo');

        // Owner's account
        $stmt->bindParam(':accountNo', $ownerAccountNo);
        $stmt->execute();
        $ownerAccount = $stmt->fetch(PDO::FETCH_ASSOC);

        // Beneficiary's account
        $stmt->bindParam(':accountNo', $beneficiaryAccountNo);
        $stmt->execute();
        $beneficiaryAccount = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($ownerAccount && $beneficiaryAccount) {
            $ownerBalanceBefore = $ownerAccount['Balance'];
            $beneficiaryBalanceBefore = $beneficiaryAccount['Balance'];

            if ($ownerBalanceBefore >= $transferAmount) {
                $ownerBalanceAfter = $ownerBalanceBefore - $transferAmount;
                $beneficiaryBalanceAfter = $beneficiaryBalanceBefore + $transferAmount;

                // Update the balances
                $stmt = $pdo->prepare('UPDATE Accounts SET Balance = :balance WHERE AccountNumber = :accountNo');

                // Update owner's balance
                $stmt->bindParam(':balance', $ownerBalanceAfter);
                $stmt->bindParam(':accountNo', $ownerAccountNo);
                $stmt->execute();

                // Update beneficiary's balance
                $stmt->bindParam(':balance', $beneficiaryBalanceAfter);
                $stmt->bindParam(':accountNo', $beneficiaryAccountNo);
                $stmt->execute();

                // Record the transactions
                $stmt = $pdo->prepare('INSERT INTO Transactions (AccountID, TransactionType, Amount, Balance_Before, Balance_After, Description)
                                       VALUES (:accountId, "Transfer", :amount, :balanceBefore, :balanceAfter, :description)');

                // Record transfer from owner
                $stmt->bindParam(':accountId', $ownerAccount['AccountId']);
                $stmt->bindParam(':amount', $transferAmount);
                $stmt->bindParam(':balanceBefore', $ownerBalanceBefore);
                $stmt->bindParam(':balanceAfter', $ownerBalanceAfter);
                $stmt->bindParam(':description', $description);
                $stmt->execute();

                // Record transfer to beneficiary
                $stmt->bindParam(':accountId', $beneficiaryAccount['AccountId']);
                $stmt->bindParam(':amount', $transferAmount);
                $stmt->bindParam(':balanceBefore', $beneficiaryBalanceBefore);
                $stmt->bindParam(':balanceAfter', $beneficiaryBalanceAfter);
                $stmt->bindParam(':description', $description);
                $stmt->execute();

                // Log the admin action
                $action = 'Transfer';
                $ipAddress = $_SERVER['REMOTE_ADDR'];
                $description = "Admin recorded a transfer of $transferAmount from account $ownerAccountNo to account $beneficiaryAccountNo";

                $stmt = $pdo->prepare('INSERT INTO AuditLogs (UserId, Action, IP_Address, Description) VALUES (:adminUserId, :action, :ipAddress, :description)');
                $stmt->bindParam(':adminUserId', $adminUserId);
                $stmt->bindParam(':action', $action);
                $stmt->bindParam(':ipAddress', $ipAddress);
                $stmt->bindParam(':description', $description);
                $stmt->execute();

                // Commit the transaction
                $pdo->commit();

                echo "Transfer recorded successfully!";
            } else {
                echo "Insufficient funds in owner's account!";
            }
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
