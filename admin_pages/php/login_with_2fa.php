<?php
session_start();
header('Content-Type: application/json');
require 'db_connect.php'; // Include your database connection

function generateResponse($success, $message = '', $twofa_required = false) {
    return json_encode(['success' => $success, 'message' => $message, 'twofa_required' => $twofa_required]);
}

function generate2FACode($pdo, $userId, $email) {
    $code = rand(100000, 999999); // Generate a random 6-digit code
    $expirationTime = date('Y-m-d H:i:s', strtotime('+10 minutes')); // Set expiration time 10 minutes from now

    // Insert the 2FA code into the database
    $stmt = $pdo->prepare('INSERT INTO TwoFactorAuthCodes (UserID, Code, ExpirationTime) VALUES (?, ?, ?)');
    $stmt->execute([$userId, $code, $expirationTime]);

    // Send the code via email
    $subject = "Your 2FA Code";
    $message = "Your 2FA code is $code. It is valid for 10 minutes.";
    $headers = "From: info@shegnetkonsult.com.ng\r\n";
    $headers .= "Reply-To: no-reply@shegnetkonsult.com.ng\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    mail($email, $subject, $message, $headers);

    return $code;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $twoFaCode = $_POST['2faCode'] ?? '';

    // Check if 2FA code is provided
    if (!empty($twoFaCode)) {
        // Verify the 2FA code
        $stmt = $pdo->prepare('SELECT * FROM TwoFactorAuthCodes WHERE UserID = ? AND Code = ? AND ExpirationTime > NOW() AND IsUsed = 0');
        $stmt->execute([$_SESSION['UserId'], $twoFaCode]);
        $codeData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($codeData) {
            // Mark the 2FA code as used
            $stmt = $pdo->prepare('UPDATE TwoFactorAuthCodes SET IsUsed = 1 WHERE CodeID = ?');
            $stmt->execute([$codeData['CodeID']]);

            // 2FA successful, log the user in
            echo generateResponse(true, '2FA successful');
        } else {
            echo generateResponse(false, 'Invalid or expired 2FA code');
        }
        exit();
    }

    // Regular login process
    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare('SELECT * FROM Users WHERE Username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['Password'])) {
            // Set session variables
            $_SESSION['UserId'] = $user['UserId'];
            $_SESSION['Username'] = $user['Username'];
            $_SESSION['Role'] = $user['Role'];

            // Check if 2FA is required
            $stmt = $pdo->prepare('SELECT * FROM TwoFactorAuthCodes WHERE UserID = ? AND ExpirationTime > NOW() AND IsUsed = 0');
            $stmt->execute([$user['UserId']]);
            $twoFaCodeData = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$twoFaCodeData) {
                // Generate and send a new 2FA code if no valid code exists
                generate2FACode($pdo, $user['UserId'], $user['Email']);
                echo generateResponse(false, '2FA required. Check your email for the code.', true);
            } else {
                // 2FA code exists and is valid, login directly
                echo generateResponse(true, 'Login successful');
            }
        } else {
            echo generateResponse(false, 'Invalid username or password');
        }
    } else {
        echo generateResponse(false, 'Username and password are required');
    }
} else {
    echo generateResponse(false, 'Invalid request method');
}
?>
