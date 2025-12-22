<?php
session_start(); // Start the session

// Ensure the user is logged in
if (!isset($_SESSION['UserId'])) {
    echo '<div class="alert alert-danger">You must be logged in to create farm profile.</div>';
    exit();
}

// Include the database connection
include 'db_connect.php';

// Get UserID from session
$userId = $_SESSION['UserId'];

// Generate a unique account number
$farmSize = $_POST['farmSize'];
$farmLocation = $_POST['farmLocation'];
$farmType = $_POST['farmType'];
$cropLists = $_POST['cropLists'];
$livestockLists = $_POST['livestockLists'];

// Prepare the SQL query
$sql = "INSERT INTO farms (UserID, farmSize, farmLocation, farmType, cropLists, livestockLists, dateEdited, status)
        VALUES (?, ?, ?, ?, ?, ?, NOW(), 'Active')";

// Prepare statement
$stmt = $pdo->prepare($sql);

// Execute statement
if ($stmt->execute([$userId, $farmSize, $farmLocation, $farmType, $cropLists, $livestockLists])) {
    echo '<div class="alert alert-success">Farm Details successfully Entered!</div>';
} else {
    echo '<div class="alert alert-danger">Error entering details: ' . htmlspecialchars($stmt->errorInfo()[2]) . '</div>';
}
?>
