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
    echo '<div class="alert alert-info">You currently have no ongoing or pending loan request</div>';

else if ($Loan and $Loan['Status'] <> 'Paid') {
    // If a pending loan exists
    if($Loan['Status'] == 'Pending'){
        $this_amount = $Loan['Amount'];
        echo '<div class="alert alert-info">Pending Loan awaiting approval (Amount =  '. formatAsNaira($this_amount). '). One of our staffs will contact you shortly. </div>';
    }
    // If a loan is APproved
    else if($Loan['Status'] == 'Approved'){
        $this_amount = $Loan['Amount'];
        $the_date = new DateTime($Loan['Approved_At']);
        $pay_start_date = new DateTime($Loan['Approved_At']);
        $pay_start_date->modify("+6 months");
        echo '<div class="alert alert-info">Your Loan application (Amount =  '. formatAsNaira($this_amount). ') has been approved. Expect the money to be disbursed into your account within two weeks. <br><br>The loan comes with an interest of 7% and you are expected to start payment from six months time. <br><br>This implies that you will pay back a total of '. formatAsNaira($this_amount+($this_amount*0.07)). ' within thirty months. As such you are expected to pay back '. formatAsNaira(($this_amount+($this_amount*0.07))/30). ' every '. $the_date->format("jS"). ' day of the month starting from '. $pay_start_date->format("Y-m-d"). '.<br><br>If you dont agree with this, contact our bank branch quickly so as to reject disbursement. Thank you</div>';
    }
    // If an active loan exists
    else if($Loan['Status'] == 'Active'){
        $this_amount = $Loan['Amount'];
        $remaining_balance = $Loan['RemainingBalance'];
        $the_date = new DateTime($Loan['Approved_At']);
        $pay_start_date = new DateTime($Loan['Approved_At']);
        $pay_start_date->modify("+6 months");
        echo '<div class="alert alert-info">The Loan you applied for (Amount =  '. formatAsNaira($this_amount). ') has been disbursed into your account. Your loan balance = '. formatAsNaira($remaining_balance). '<br><br>Recall that you are expected to pay '. formatAsNaira(($this_amount+($this_amount*0.07))/30). ' every '. $the_date->format("jS"). ' day of the month starting from '. $pay_start_date->format("Y-m-d"). '.<br><br>Note that failure to pay back for three consecutive months will make our staffs be on your heel. <br><br>To make your loan repayments, ensure you have more than '. formatAsNaira(($this_amount+($this_amount*0.07))/30). ' in your account and make this payment in the "Loan Repayment section" on your dashboard. Thank you</div>';
    }
}
?>
