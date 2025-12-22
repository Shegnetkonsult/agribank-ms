<?php
include 'db_connect.php';
include 'functions.php';

$query = $pdo->query("SELECT * FROM Users, Loans WHERE Loans.UserId = Users.UserID AND Loans.status = 'Pending'");
$loans = $query->fetchAll(PDO::FETCH_ASSOC);

$output = '<table class="table table-striped">';
$output .= '<thead><tr><th>Loan ID</th><th>Username</th><th>Amount</th><th>Type</th><th>Action</th></tr></thead><tbody>';

foreach ($loans as $loan) {
    $output .= '<tr>';
    $output .= '<td>' . $loan['LoanId'] . '</td>';
    $output .= '<td>' . $loan['FullName'] . '</td>';
    $output .= '<td>' . formatAsNaira($loan['Amount']) . '</td>';
    $output .= '<td>' . $loan['LoanType'] . '</td>';
    $output .= '<td>
        <button class="btn btn-success view-loan-btn" data-loan-id="' . $loan['LoanId'] . '">Details</button>
        <button class="btn btn-success approve-loan-btn" data-loan-id="' . $loan['LoanId'] . '">Approve</button>
        <button class="btn btn-danger reject-loan-btn" data-loan-id="' . $loan['LoanId'] . '">Reject</button>
    </td>';
    $output .= '</tr>';
}

$output .= '</tbody></table>';
echo $output;
?>
