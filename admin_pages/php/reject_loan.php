<?php
include 'db_connect.php';
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['UserId'])) {
    echo '<div class="alert alert-danger">You must be logged in to perform this action.</div>';
    exit();
}

    //Approve Loan
    $loanId = $_POST['loanId'];
    $query = $pdo->prepare("UPDATE Loans SET Status = 'Rejected', Approved_At = Now() WHERE LoanId = ?");
    $query->execute([$loanId]);

    // Get Admin Info from UserId session variable
    $sql = "SELECT * FROM Users WHERE UserId = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['UserId']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $adminUserId = $user['UserId'];

    // Get User Information from
    $sql = "SELECT * FROM Users, Loans WHERE Users.UserId = Loans.UserId AND LoanId = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$loanId]);
    $Loan = $stmt->fetch(PDO::FETCH_ASSOC);

    // Log the action
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $action = "Admin User ". $_SESSION['UserId']. ' Rejected Loan for Customer : '. $Loan['UserId'];
    $description = $user['FullName']. ', Banker with User ID: '. $_SESSION['UserId']. ' Approved Loan for: '. $Loan['FullName']. ' with UserID: '. $Loan['UserId']. "By doing this, the banker accept that the bank branch has discerned that the customer is not worthy of the value applied for";

    $stmt = $pdo->prepare('INSERT INTO AuditLogs (UserId, Action, IP_Address, Description) VALUES (:adminUserId, :action, :ipAddress, :description)');
    $stmt->bindParam(':adminUserId', $adminUserId);
    $stmt->bindParam(':action', $action);
    $stmt->bindParam(':ipAddress', $ipAddress);
    $stmt->bindParam(':description', $description);
    $stmt->execute();

    echo "Loan rejected successfully.";
?>
