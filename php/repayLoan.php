<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['UserId'])) {
    echo '<div class="alert alert-danger">User not authenticated. Please log in.</div>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['UserId'];
    $loanAmount = $_POST['loanAmount'];

    try {
        $pdo->beginTransaction();

        // Fetch user's account information
        $stmt = $pdo->prepare('SELECT * FROM Accounts WHERE UserID = :userId AND Status = "Active" LIMIT 1');
        $stmt->execute(['userId' => $userId]);
        $account = $stmt->fetch();

        if (!$account) {
            echo '<div class="alert alert-danger">Account not found or inactive.</div>';
            exit;
        }

        $accountId = $account['AccountId'];
        $balanceBefore = $account['Balance'];

        if ($balanceBefore < $loanAmount) {
            echo '<div class="alert alert-danger">Insufficient balance.</div>';
            exit;
        }

        // Update account balance
        $balanceAfter = $balanceBefore - $loanAmount;
        $stmt = $pdo->prepare('UPDATE Accounts SET Balance = :balanceAfter WHERE AccountId = :accountId');
        $stmt->execute(['balanceAfter' => $balanceAfter, 'accountId' => $accountId]);

        // Update loan balance
        $stmt = $pdo->prepare('SELECT * FROM Loans WHERE UserId = :userId AND Status = "Active" LIMIT 1');
        $stmt->execute(['userId' => $userId]);
        $loan = $stmt->fetch();

        if (!$loan) {
            echo '<div class="alert alert-danger">Active loan not found.</div>';
            exit;
        }

        $loanId = $loan['LoanId'];
        $remainingBalance = $loan['Amount'] - $loanAmount;

        if ($remainingBalance <= 0) {
            $loanStatus = 'Paid';
        } else {
            $loanStatus = 'Active';
        }

        $stmt = $pdo->prepare('UPDATE Loans SET Amount = :remainingBalance, Status = :loanStatus WHERE LoanId = :loanId');
        $stmt->execute(['remainingBalance' => $remainingBalance, 'loanStatus' => $loanStatus, 'loanId' => $loanId]);

        // Insert transaction record
        $stmt = $pdo->prepare('INSERT INTO Transactions (AccountID, TransactionType, Amount, Balance_Before, Balance_After, Description) VALUES (:accountId, "Loan Payment", :amount, :balanceBefore, :balanceAfter, "Loan repayment")');
        $stmt->execute(['accountId' => $accountId, 'amount' => $loanAmount, 'balanceBefore' => $balanceBefore, 'balanceAfter' => $balanceAfter]);

        // Log the action in AuditLogs
        $stmt = $pdo->prepare('INSERT INTO AuditLogs (UserId, Action, IP_Address, Description) VALUES (:userId, "Loan Repayment", :ipAddress, "User repaid loan amount")');
        $stmt->execute(['userId' => $userId, 'ipAddress' => $_SERVER['REMOTE_ADDR']]);

        $pdo->commit();

        echo '<div class="alert alert-success">Loan repayment successful.</div>';
    } catch (Exception $e) {
        $pdo->rollBack();
        echo '<div class="alert alert-danger">An error occurred: ' . $e->getMessage() . '</div>';
    }
}
?>
