<?php
session_start(); // Start the session

// Ensure the user is logged in
if (!isset($_SESSION['UserId'])) {
    echo '<div class="alert alert-danger">You must be logged in to create farm profile.</div>';
    exit();
}

// Include the database connection
require 'db_connect.php';

//Check if account form has been posted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $criteria = $_POST['searchCriteria'];
    $input = $_POST['searchInput'];

    try {
        // Determine which table and column to search in based on criteria
        switch ($criteria) {
            case 'username':
                $column = 'Username';
                $table = 'Users';
                break;
            case 'account_number':
                $column = 'AccountNumber';
                $table = 'Accounts';
                break;
            case 'email':
                $column = 'Email';
                $table = 'Users';
                break;
            case 'phone':
                $column = 'PhoneNumber';
                $table = 'Users';
                break;
            default:
                throw new Exception("Invalid search criteria");
        }

        // Prepare the SQL query with a JOIN for account details
        if ($table == 'Users') {
            $query = "SELECT Users.Username, Accounts.AccountNumber, Users.Email, Users.PhoneNumber
                      FROM Users
                      LEFT JOIN Accounts ON Users.UserId = Accounts.UserID
                      WHERE $column = :input";
        } else {
            $query = "SELECT Users.Username, Accounts.AccountNumber, Users.Email, Users.PhoneNumber
                      FROM Accounts
                      LEFT JOIN Users ON Accounts.UserID = Users.UserId
                      WHERE $column = :input";
        }

        $stmt = $pdo->prepare($query);
        $stmt->execute(['input' => $input]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            echo '<style>
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin: 20px 0;
                        font-size: 1em;
                        font-family: Arial, sans-serif;
                        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
                    }
                    table th, table td {
                        padding: 12px 15px;
                        border: 1px solid #ddd;
                    }
                    table th {
                        background-color: #f4f4f4;
                        text-align: left;
                    }
                    table tr:nth-of-type(even) {
                        background-color: #f9f9f9;
                    }
                    table tr:hover {
                        background-color: #f1f1f1;
                    }
                  </style>';
            echo '<table>';
            echo '<tr><th>Username</th><th>Account Number</th><th>Email</th><th>Phone Number</th></tr>';
            foreach ($results as $row) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['Username']) . '</td>';
                echo '<td>' . htmlspecialchars($row['AccountNumber']) . '</td>';
                echo '<td>' . htmlspecialchars($row['Email']) . '</td>';
                echo '<td>' . htmlspecialchars($row['PhoneNumber']) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No results found.</p>';
        }
    } catch (Exception $e) {
        echo '<p>An error occurred: ' . $e->getMessage() . '</p>';
    }
}
?>
