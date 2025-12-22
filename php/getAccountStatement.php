<?php
session_start();
require 'db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['UserId'])) {
    echo "You need to log in to view your account statements.";
    exit;
}

$UserId = $_SESSION['UserId'];

// Fetch user's account details
$stmt = $pdo->prepare("SELECT AccountId, AccountNumber, AccountType, Balance FROM Accounts WHERE UserID = :UserId AND Status = 'Active'");
$stmt->execute(['UserId' => $UserId]);
$accounts = $stmt->fetchAll();

// Fetch transactions for each account
$transactions = [];
foreach ($accounts as $account) {
    $stmt = $pdo->prepare("SELECT * FROM Transactions WHERE AccountID = :AccountID ORDER BY Date DESC");
    $stmt->execute(['AccountID' => $account['AccountId']]);
    $transactions[$account['AccountId']] = $stmt->fetchAll();
}

// Generate the HTML response
$response = '<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }
    th, td {
        padding: 12px;
        border: 1px solid #dee2e6;
        text-align: left;
    }
    th {
        background-color: #343a40;
        color: #ffffff;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    h2 {
        font-family: Arial, sans-serif;
        color: #343a40;
    }
    p {
        font-family: Arial, sans-serif;
        color: #495057;
    }
</style>';

foreach ($accounts as $account) {
    $response .= '<h2>Account Number: ' . htmlspecialchars($account['AccountNumber']) . ' (' . htmlspecialchars($account['AccountType']) . ')</h2>';
    $response .= '<p>Balance: $' . number_format($account['Balance'], 2) . '</p>';
    $response .= '<table>';
    $response .= '<thead><tr><th>Transaction ID</th><th>Type</th><th>Amount</th><th>Date</th><th>Status</th><th>Description</th><th>Balance Before</th><th>Balance After</th></tr></thead>';
    $response .= '<tbody>';

    if (empty($transactions[$account['AccountId']])) {
        $response .= '<tr><td colspan="8">No transactions found for this account.</td></tr>';
    } else {
        foreach ($transactions[$account['AccountId']] as $transaction) {
            $response .= '<tr>';
            $response .= '<td>' . htmlspecialchars($transaction['TransactionsId']) . '</td>';
            $response .= '<td>' . htmlspecialchars($transaction['TransactionType']) . '</td>';
            $response .= '<td>$' . number_format($transaction['Amount'], 2) . '</td>';
            $response .= '<td>' . htmlspecialchars($transaction['Date']) . '</td>';
            $response .= '<td>' . htmlspecialchars($transaction['Status']) . '</td>';
            $response .= '<td>' . htmlspecialchars($transaction['Description']) . '</td>';
            $response .= '<td>$' . number_format($transaction['Balance_Before'], 2) . '</td>';
            $response .= '<td>$' . number_format($transaction['Balance_After'], 2) . '</td>';
            $response .= '</tr>';
        }
    }

    $response .= '</tbody></table>';
}

echo $response;
?>
