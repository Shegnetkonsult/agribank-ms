Sure, I'll create a simple login system where the user logs in via a form, and upon successful login, they are redirected to the `dashboard.php` page. The `dashboard.php` page will display the username which will be sent via `$_GET`.

### HTML (log_in.html)
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/form_styles.css">
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <form id="loginForm">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
            <p id="loginMessage"></p>
        </form>
    </div>

    <script src="js/log_in_script.js"></script>
</body>
</html>
```

### JavaScript (log_in_script.js)
```javascript
document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch('php/login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('loginMessage').textContent = data.message;
        if (data.status === "success") {
            // Redirect to dashboard with username as GET parameter
            window.location.href = 'dashboard.php?username=' + encodeURIComponent(data.username);
        }
    })
    .catch(error => console.error('Error:', error));
});
```

### PHP (login.php)
```php
<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Prepare the SQL query to select the user by username
        $stmt = $pdo->prepare('SELECT UserId, Password FROM Users WHERE Username = :username AND Status = "Active" AND Role > 1');
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['Password'])) {
            // Set session variables for logged-in user
            $_SESSION['UserId'] = $user['UserId'];
            $_SESSION['Username'] = $username;

            // Return success response with username
            echo json_encode(["status" => "success", "message" => "Login success!", "username" => $username]);
        } else {
            // Invalid username or password
            echo json_encode(["status" => "error", "message" => "Invalid username or password!"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method!"]);
}
?>
```

### PHP (dashboard.php)
```php
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome to the Dashboard</h2>
    <form>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo isset($_GET['username']) ? htmlspecialchars($_GET['username']) : ''; ?>" readonly>
    </form>
</body>
</html>
```

### PHP (db_connect.php)
```php
<?php
// Database connection using PDO
$host = 'localhost';  // Change as per your database
$dbname = 'db_boa';  // Your database name
$username = 'root';  // Your MySQL username
$password = '';  // Your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: Could not connect to the database. " . $e->getMessage());
}
?>
```

### Explanation
1. **HTML (log_in.html)**:
   - A simple login form with fields for username and password.
   - Includes a JavaScript file (`log_in_script.js`) to handle form submission via AJAX.

2. **JavaScript (log_in_script.js)**:
   - Listens for the form submission event, prevents the default form submission behavior, and sends an AJAX POST request to `login.php`.
   - On successful login, the user is redirected to `dashboard.php` with the username included in the URL as a `GET` parameter.

3. **PHP (login.php)**:
   - Handles the form submission, verifies the username and password against the database, and sets session variables.
   - Returns a JSON response with the login status and username.

4. **PHP (dashboard.php)**:
   - Displays a form with the username retrieved from the `GET` parameter.

5. **PHP (db_connect.php)**:
   - Handles the database connection using PDO.
