<?php
session_start();
require_once 'db_connect.php'; // Include your DB connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $twoFactorCode = $_POST['twoFactorCode'];
    $userId = $_SESSION['UserId'];

    $stmt = $pdo->prepare("SELECT * FROM TwoFactorAuthCodes WHERE UserID = ? AND Code = ? AND IsUsed = 0 AND ExpirationTime > NOW()");
    $stmt->execute([$userId, $twoFactorCode]);
    $code = $stmt->fetch();

    if ($code) {
        // Mark the code as used
        $stmt = $pdo->prepare("UPDATE TwoFactorAuthCodes SET IsUsed = 1 WHERE CodeID = ?");
        $stmt->execute([$code['CodeID']]);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid or expired 2FA code']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
