Yes, session variables can be set and retrieved when using AJAX. However, there are a few common pitfalls that can cause issues with sessions in AJAX requests. Here are some key things to check:

1. **Session Start**: Ensure that `session_start()` is called at the beginning of every PHP script that needs access to the session, including those called via AJAX.

2. **Same Domain**: Ensure the AJAX request is being made to the same domain and path as where the session was started. Cross-domain requests can lead to issues with sessions.

3. **Cookies**: Sessions are typically managed via cookies. Ensure that cookies are enabled and being sent correctly with your AJAX requests.

4. **Consistent Session ID**: Ensure that the session ID remains consistent across requests. Sometimes issues with session ID regeneration can cause problems.

5. **Correct Session Handling in PHP**: Verify that the session is correctly handled in your PHP scripts.

### Here is a simple example to demonstrate setting and retrieving session variables using AJAX:

#### HTML (log_in.html)
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

#### JavaScript (log_in_script.js)
```javascript
document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch('php/login.php', {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'  // Include cookies in the request
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

#### PHP (login.php)
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

#### PHP (dashboard.php)
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

#### PHP (db_connect.php)
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

### Additional Troubleshooting Steps

1. **Check for Session Start**: Ensure `session_start()` is at the top of every PHP script that needs session access.

2. **Cookie Settings**: Ensure cookies are enabled in your browser and that the `session.cookie_lifetime` and `session.cookie_path` settings are correctly configured in `php.ini`.

3. **Check for Session ID Consistency**: Ensure the session ID remains the same across requests. You can print the session ID using `session_id()` to verify.

4. **File Permissions**: Ensure the web server has permission to read and write session files. On Linux, this is often `/var/lib/php/sessions/`. On Windows, check the session.save_path directory in `php.ini`.

5. **Browser Cache**: Clear your browser cache and cookies to ensure that old session data is not interfering.

6. **Debugging**: Add `var_dump($_SESSION);` at the beginning and end of your PHP scripts to see the state of the session variables at different points in the execution flow.
