<?php
// Include connection string
	require_once 'db_connect.php';
		session_start();
		
//Log action taken by admin		
if(isset($_SESSION['UserId'])){
        // Prepare the SQL query to select the user by username
        $stmt = $pdo->prepare('SELECT * FROM Users WHERE UserId = :UserId');
        $stmt->bindParam(':UserId', $_SESSION['UserId']);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $this_id = $user['UserId'];
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $action = 'User Logged Out';
        $description = $user['Username']. ' Log out successfully';

		// Insert login attempt into AuditLogs
		$stmt = $pdo->prepare('INSERT INTO AuditLogs (UserId, Action, IP_Address, Description) VALUES (:userId, :action, :ipAddress, :description)');
		$stmt->bindParam(':userId', $user['UserId']);
		$stmt->bindParam(':action', $action);
		$stmt->bindParam(':ipAddress', $ipAddress);
		$stmt->bindParam(':description', $description);
		$stmt->execute();
}
   if(session_destroy()) {
      header("Location:../index.php");
   }
?>
