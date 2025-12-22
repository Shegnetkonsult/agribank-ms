It seems like there might be a few issues specific to your Windows environment that are causing problems with session handling and AJAX requests. Let's tackle this step by step:

1. **Double-Check Session Configuration in `php.ini`**
   - Ensure that your `php.ini` file on Windows has the correct settings for sessions. Specifically, check `session.save_path` and other session-related configurations.

2. **Ensure Session Storage Path is Writable**
   - Make sure the session storage path specified in `php.ini` is writable by the web server. Sometimes, permissions can cause issues on Windows.

3. **Debugging the AJAX Request**
   - Let's make sure that the AJAX request is working correctly and that the session is being handled properly. We will use `fetch` with `credentials: 'same-origin'` to ensure cookies (and thus session IDs) are sent.

### Update `log_in.html`
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
    <header class="bg-success text-white">
        <nav class="navbar navbar-expand-lg navbar-light container">
            <a class="navbar-brand" href="#">
                <img src="img/logo.png" alt="Bank of Agriculture Logo" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link text-white" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#about">About Us</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#contact">Contact</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="log_in.html">Login</a></li>
                </ul>
            </div>
        </nav>
    </header>
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

### Update `log_in_script.js`
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
            // Redirect to dashboard
            window.location.href = 'dashboard.php';
        }
    })
    .catch(error => console.error('Error:', error));
});
```

### Update `login.php`
```php
<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare('SELECT UserId, Password FROM Users WHERE Username = :username AND Status = "Active" AND Role > 1');
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['Password'])) {
            session_regenerate_id(true); // Regenerate session ID on successful login
            $_SESSION['UserId'] = $user['UserId'];
            $_SESSION['Username'] = $username;

            // Debugging statement
            //var_dump($_SESSION);

            echo json_encode(["status" => "success", "message" => "Login success!", "username" => $username]);
        } else {
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

### Update `dashboard.php`
```php
<?php
session_start();

// Debugging statement
var_dump($_SESSION);

if (!isset($_SESSION['UserId'])) {
    header("Location: log_in.html");
    exit();
}
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
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['Username']); ?>" readonly>
    </form>
</body>
</html>
```

### Additional Debugging Steps
1. **Check Session Save Path on Windows:**
   - Ensure that the session save path specified in your `php.ini` is correct and writable.
   ```ini
   session.save_path = "C:\path\to\your\sessions"
   ```

2. **Set Session Cookie Parameters:**
   - Set consistent session cookie parameters in your PHP scripts.
   ```php
   <?php
   ini_set('session.cookie_path', '/');
   ini_set('session.cookie_domain', ''); // Leave empty for localhost

   session_start();
   ?>
   ```

3. **Check PHP Error Logs:**
   - Check the PHP error logs for any errors related to session handling.

By ensuring that sessions are started at the top of each PHP file, cookies are included in AJAX requests, and session configuration is consistent, you can help maintain consistent session ID handling across your application.
