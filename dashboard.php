<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['UserId'])) {
    // If not logged in, redirect to the login page
    header("Location: log_in.html");
    exit(); // Stop further execution
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer-Friendly Banking System</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/loan-management-content.js"></script>
    <script src="js/transaction-management-content.js"></script>
    <script src="js/account-management-content.js"></script>
    <script src="js/reporting-management-content.js"></script>
</head>
<body>
    <!-- Header -->
    <header class="bg-success text-white">
        <nav class="navbar navbar-expand-lg navbar-light container">
            <a class="navbar-brand" href="#">
                <img src="img/logo.png" alt="Bank of Agriculture Logo" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link text-white" href="php/log_out.php">Log Out</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="container">
        <h1 class="mt-5">Farmer-Friendly Banking System Dashboard</h1>
        <div class="row mt-4">
            <div class="col-md-3">
                <ul class="nav flex-column nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" id="account-management-tab" data-toggle="pill" href="#account-management">Account Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="loan-management-tab" data-toggle="pill" href="#loan-management">Loan Management</a>
                    </li>
                    <!--li class="nav-item">
                        <a class="nav-link" id="crop-insurance-tab" data-toggle="pill" href="#crop-insurance">Crop Insurance</a>
                    </li-->
                    <li class="nav-item">
                        <a class="nav-link" id="transaction-management-tab" data-toggle="pill" href="#transaction-management">Transaction Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="reporting-tab" data-toggle="pill" href="#reporting-management">Reporting</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="tab-content">
                    <!-- Account Management -->
                    <div class="tab-pane fade show active" id="account-management">
                        <h3>Account Management</h3>
                        <button class="btn btn-primary" onclick="showCreateFarmerProfile()">Enter Farm Details</button>
                        <button class="btn btn-primary" onclick="showOpenAccount()">Open Savings/Current Account</button>
                        <button class="btn btn-primary" onclick="showAccountBalances()">Account Balances</button>

                        <div id="account-management-content" class="mt-4"></div>
                    </div>

                    <!-- Loan Management -->
                    <div class="tab-pane fade" id="loan-management">
                        <h3>Loan Management</h3>
                        <button class="btn btn-primary" onclick="showApplyForLoan()">Apply for Loan</button>
                        <button class="btn btn-primary" onclick="showLoanStatus()">View Loan Status</button>
                        <button class="btn btn-primary" onclick="showLoanRepayment()">Loan Repayment</button>
                        <div id="loan-management-content" class="mt-4"></div>
                    </div>

                    <!-- Crop Insurance -->
                    <div class="tab-pane fade" id="crop-insurance">
                        <h3>Crop Insurance</h3>
                        <button class="btn btn-primary" onclick="showApplyForInsurance()">Apply for Crop Insurance</button>
                        <button class="btn btn-primary" onclick="showApproveRejectInsurance()">Approve/Reject Insurance</button>
                        <button class="btn btn-primary" onclick="showPayPremium()">Pay Premium</button>
                        <button class="btn btn-primary" onclick="showClaimSettlement()">Claim Settlement</button>

                        <div id="crop-insurance-content" class="mt-4"></div>
                    </div>

                    <!-- Transaction Management -->
                    <div class="tab-pane fade" id="transaction-management">
                        <h3>Transaction Management</h3>
                        <button class="btn btn-primary" onclick="showDeposit()">Deposit</button>
                        <button class="btn btn-primary" onclick="showWithdrawal()">Withdrawal</button>
                        <button class="btn btn-primary" onclick="showTransfer()">Transfer</button>

                        <div id="transaction-management-content" class="mt-4"></div>
                    </div>

                    <!-- Reporting -->
                    <div class="tab-pane fade" id="reporting-management">
                        <h3>Reporting</h3>
                        <button class="btn btn-primary" onclick="showAccountStatement()">Account Statement</button>
                        <button class="btn btn-primary" onclick="showLoanRepaymentSchedule()">Loan Repayment Schedule</button>
                        <!--button class="btn btn-primary" onclick="showCropInsuranceStatus()">Crop Insurance Status</button-->

                        <div id="reporting-management-content" class="mt-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/dashboard.js"></script>


</body>
</html>
