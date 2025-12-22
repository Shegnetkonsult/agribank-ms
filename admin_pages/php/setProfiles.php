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

// Get the account numbers from the posted values
if(isset($_POST['account_number_1'])){
    $account_number_1 = $_POST['account_number_1'];
    // Select OwnerAccount Information
    $sql = "SELECT * FROM Accounts WHERE AccountNumber = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$account_number_1]);
    $owner_account = $stmt->fetch(PDO::FETCH_ASSOC);
}
if(isset($_POST['account_number_2'])){
    $account_number_2 = $_POST['account_number_2'];
    // Select Beneficiary Account Information
    $sql = "SELECT * FROM Accounts WHERE AccountNumber = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$account_number_2]);
    $beneficiary_account = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($owner_account) {
    // If beneficiary account exists
    $_SESSION['owner_account_no'] = $owner_account['AccountNumber'];
    $_SESSION['owner_user_id'] = $owner_account['UserID'];
    echo 'ACCOUNT INFO: BVN: ('. $owner_account['bvn']. ") ". 'Balance: ('. formatAsNaira($owner_account['Balance']). ")<BR>";
}
else echo "No Owner account number inputted or does not exist <BR>";

if ($beneficiary_account) {
    // If beneficiary account exists
    $_SESSION['beneficiary_account_no'] = $beneficiary_account['AccountNumber'];
    $_SESSION['beneficiary_user_id'] = $beneficiary_account['UserID'];
    echo 'BENEFICIARY ACCOUNT INFO: BVN('. $beneficiary_account['bvn']. ") ". 'Balance: '. formatAsNaira($beneficiary_account['Balance']). "<BR>";
}
else echo "No Beneficiary account number inputted or does not exist <BR>";
?>
