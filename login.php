<?php
require 'includes/db.php';
include 'includes/header.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header('Location: dashboard.php');
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<h2>Login</h2>
<?php if (isset($error_message)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
<?php endif; ?>
<form method="post" action="login.php">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>
<p>Don't have an account? <a href="register.php">Register here</a></p>
<?php include 'includes/footer.php'; ?>
