<?php
session_start(); // Start the session

// Ensure the user is logged in
if (!isset($_SESSION['UserId'])) {
    echo '<div class="alert alert-danger">You must be logged in to create an account.</div>';
    exit();
}

// Include the database connection
include 'db_connect.php';
include 'functions.php';

// Get UserID from session
$userId = $_SESSION['UserId'];

// Check if the user already has an account
$sql = "SELECT * FROM Loans WHERE UserId = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userId]);
$Loan = $stmt->fetch(PDO::FETCH_ASSOC);


if ($Loan) {
    // If an active loan already exists
    if($Loan['Status'] == 'Active'){
        $remaining_amount = $Loan['RemainingBalance'];
        echo '<div class="alert alert-info">You currently have an active loan (Remaining balance =  '. formatAsNaira($remaining_amount). ') and can not apply for another loan now. Please try back after you offsets your loan </div>';
        exit();
    }
    // If a pending loan already exists
    if($Loan['Status'] == 'Pending'){
        $this_amount = $Loan['Amount'];
        echo '<div class="alert alert-info">We are aware of your pending loan request (Amount =  '. formatAsNaira($this_amount). '). Please hold on for a shortwhile, one of our staffs will contact you soonest. </div>';
        exit();
    }
}

// Generate a unique account number
$amount = $_POST['loanAmount'];
$loantype = $_POST['loanType'];

// Prepare the SQL query
$sql = "INSERT INTO Loans (UserId, LoanType, Amount, ApplicationDate, Status)
        VALUES (?, ?, ?, NOW(), 'Pending')";

// Prepare statement
$stmt = $pdo->prepare($sql);

// Execute statement
if ($stmt->execute([$userId, $loantype, $amount])) {
    echo '<div class="alert alert-success">You succesfully applied for '. formatAsNaira($amount). '! Expect one of our staffs to contact you soonest. </div>';
} else {
    echo '<div class="alert alert-danger">Error saving Loan Application : ' . htmlspecialchars($stmt->errorInfo()[2]) . '</div>';
}
?>
