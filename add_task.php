<?php
session_start();
require 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = $_POST['task_name'] ?? '';

    if (!empty($task_name)) {
        $user_id = $_SESSION['user_id'];
        $stmt = $pdo->prepare("INSERT INTO tasks (task_name, user_id) VALUES (?, ?)");
        $stmt->execute([$task_name, $user_id]);

        header('Location: dashboard.php');
        exit();
    } else {
        $error_message = "Task name cannot be empty.";
    }
}
?>

<h2>Add New Task</h2>
<?php if (isset($error_message)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
<?php endif; ?>
<form method="post" action="add_task.php">
    <input type="text" name="task_name" placeholder="Task Name" required><br>
    <button type="submit">Add Task</button>
</form>
<?php include 'includes/footer.php'; ?>
