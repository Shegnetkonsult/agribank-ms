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

if (!$Loan OR  $Loan['Status'] == 'Paid')
    echo '<div class="alert alert-info">You currently have no ongoing nor pending loan request</div>';

else if ($Loan) {
    // If a pending loan exists
    if($Loan['Status'] == 'Pending'){
        $this_amount = $Loan['Amount'];
        echo '<div class="alert alert-info">Pending Loan awaiting approval (Amount =  '. formatAsNaira($this_amount). '). One of our staffs will contact you shortly. </div>';
    }
    // If an approved loan exists
    if($Loan['Status'] == 'Active'){
        $amount = $Loan['Amount'];
        $remaining_balance = $Loan['RemainingBalance'];
        echo '<div class="alert alert-info">LOAN INFO: <br><br>Loan Amount  =  '. formatAsNaira($amount). '<br><br> Remaining balance =  '. formatAsNaira($remaining_balance). '</div>';
    }
}


// Check if the user already has an account
$sql = "SELECT * FROM Accounts WHERE UserID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userId]);
$accounts = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$accounts OR $accounts['Status'] == 'Closed') echo '<div class="alert alert-info">You currently have no Active account associated to you </div>';

else if ($accounts) {
    // If an active loan already exists
    if($accounts['Status'] == 'Active'){
        $balance = $accounts['Balance'];
        echo '<div class="alert alert-info">Bank Account (Account balance =  '. formatAsNaira($balance). ') </div>';
    }
    // If a pending loan already exists
    if($accounts['Status'] == 'Inactive'){
        $this_amount = $accounts['Amount'];
        echo '<div class="alert alert-danger">Your account (Account Balance =  '. formatAsNaira($this_amount). ') has been dormanted as you havent used it for a long while. Visit the bank if you wish to rectify this, thank you. </div>';
    }
}
?>
