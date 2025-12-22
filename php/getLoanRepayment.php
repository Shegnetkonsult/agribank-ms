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

if (!$Loan OR  $Loan['Status'] <> 'Active')
    echo '<div class="alert alert-info">You currently have no active loan</div>';

else if ($Loan and $Loan['Status'] == 'Active') {
    // If there is an active loan
        $this_amount = $Loan['Amount'];
        $remaining_balance = $Loan['RemainingBalance'];
        $the_date = new DateTime($Loan['Approved_At']);
        $pay_start_date = new DateTime($Loan['Approved_At']);
        $pay_start_date->modify("+6 months");
        echo '<div class="alert alert-info">Loaned =  '. formatAsNaira($this_amount). '<br>Loan Payment + Interest = '. formatAsNaira(($this_amount+($this_amount*0.07))). '<br><br>Remaining Balance = '. formatAsNaira($remaining_balance). '<br>Monthly Payment = '.formatAsNaira(($this_amount+($this_amount*0.07))/30). '<br>Number of Months = 30 months <br>Payment Maturity = every '. $the_date->format("jS"). ' day of the month starting from '. $pay_start_date->format("Y-m-d"). '</div>';
}
?>
