<?php
include 'db_connect.php';
include 'functions.php';

    $loanId = $_POST['loanId'];

try {
    // Start a transaction
    $pdo->beginTransaction();

    // Fetch current balance
    $stmt = $pdo->prepare('SELECT * FROM Accounts, Loans WHERE Accounts.UserID = Loans.UserId AND Loans.LoanId = :loanId');
    $stmt->bindParam(':loanId', $loanId);
    $stmt->execute();
    $account = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($account) {
        $UserId = $account['UserID'];
        $depositAmount = $account['Amount'];
        $RemainingBalance = $account['Amount'] + $account['Amount'] * 0.07;
        $balanceBefore = $account['Balance'];
        $balanceAfter = $balanceBefore + $account['Amount'];
        $accountId = $account['AccountId'];
        $ownerAccountNo = $account['AccountNumber'];

        /*Update Loan Status
        $query = $pdo->prepare("UPDATE Loans SET Status = 'Active', RemainingBalance =  WHERE LoanId = ?");
        $query->execute([$loanId]); */

        //Update Loan Status
        $query = $pdo->prepare("UPDATE Loans SET Status = 'Active', RemainingBalance = :RemainingBalance WHERE LoanId = :LoanId");
        $query->bindParam(':RemainingBalance', $RemainingBalance);
        $query->bindParam(':LoanId', $loanId);
        $query->execute();

        // Update the account balance
        $stmt = $pdo->prepare('UPDATE Accounts SET Balance = :balanceAfter WHERE AccountNumber = :ownerAccountNo');
        $stmt->bindParam(':balanceAfter', $balanceAfter);
        $stmt->bindParam(':ownerAccountNo', $ownerAccountNo);
        $stmt->execute();

        // Record the transaction
        $stmt = $pdo->prepare('INSERT INTO Transactions (AccountID, TransactionType, Amount, Date, Status, Balance_Before, Balance_After, Description)
                                VALUES (:accountId, "Deposit", :depositAmount, Now(), "Completed", :balanceBefore, :balanceAfter, "Deposit by Admin")');
        $stmt->bindParam(':accountId', $accountId);
        $stmt->bindParam(':depositAmount', $account['Amount']);
        $stmt->bindParam(':balanceBefore', $balanceBefore);
        $stmt->bindParam(':balanceAfter', $balanceAfter);
        $stmt->execute();

        // Log the admin action
        $action = 'Deposit';
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $description = "Admin recorded a deposit of ". formatAsNaira($depositAmount). " on account: $ownerAccountNo";

        $stmt = $pdo->prepare('INSERT INTO AuditLogs (UserId, Action, IP_Address, Description) VALUES (:UserId, :action, :ipAddress, :description)');
        $stmt->bindParam(':UserId', $UserId);
        $stmt->bindParam(':action', $action);
        $stmt->bindParam(':ipAddress', $ipAddress);
        $stmt->bindParam(':description', $description);
        $stmt->execute();

        // Commit the transaction
        $pdo->commit();

        echo "Loan disbursed successfully.";
    } else {
        echo "Account not found!";
    }
} catch (PDOException $e) {
    // Rollback the transaction in case of error
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
