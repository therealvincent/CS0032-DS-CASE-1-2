<?php
// 1. Set secure cookie parameters BEFORE starting the session
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => $_SERVER['HTTP_HOST'],
        'secure' => false,     // Set to true if your site uses HTTPS
        'httponly' => true,    // Prevents JS access to session cookie (NEW)
        'samesite' => 'Strict' // Mitigates CSRF (NEW)
    ]);
    session_start();
}

// 2. CSRF Token Generation (NEW)
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Hardcoded username and password
$valid_username = 'admin';
$valid_password = 'password';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 3. CSRF Token Validation (NEW)
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed.");
    }

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $valid_username && $password === $valid_password) {
        // 4. Regenerate session ID to prevent Session Fixation (NEW)
        session_regenerate_id(true); 
        
        $_SESSION['logged_in'] = true;
        $_SESSION['last_activity'] = time(); // Initialize for timeout (NEW)
        
        header('Location: index.php');
        exit;
    } else {
        $error_message = "Invalid username or password.";
    }
}

// 5. Redirect if already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Login</h1>
        
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>

        <form method="POST" class="w-50 mx-auto">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>