<?php
session_start();
require 'db_connect.php'; // Ensure you have the connection file

if (!isset($_SESSION['UserId'])) {
    echo json_encode(['error' => 'User not logged in.']);
    exit();
}

$filter = $_GET['filter'] ?? 'all';
$page = $_GET['page'] ?? 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$whereClause = '';
if ($filter !== 'all') {
    $whereClause = 'WHERE Status = :filter';
}

try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Loans $whereClause");
    if ($filter !== 'all') {
        $stmt->bindParam(':filter', $filter, PDO::PARAM_STR);
    }
    $stmt->execute();
    $totalLoans = $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT LoanId, UserId, LoanType, Amount, Status FROM Loans $whereClause LIMIT :limit OFFSET :offset");
    if ($filter !== 'all') {
        $stmt->bindParam(':filter', $filter, PDO::PARAM_STR);
    }
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $loanApplications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['applications' => $loanApplications, 'total' => $totalLoans, 'page' => $page, 'limit' => $limit]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
