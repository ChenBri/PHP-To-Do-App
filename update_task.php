<?php
session_start();
require 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$task_id = $_GET['id'] ?? null;

if (!$task_id) {
    header('Location: dashboard.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$task_id, $user_id]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    header('Location: dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = $_POST['task_name'] ?? '';

    if (!empty($task_name)) {
        $stmt = $pdo->prepare("UPDATE tasks SET task_name = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$task_name, $task_id, $user_id]);

        header('Location: dashboard.php');
        exit();
    } else {
        $error_message = "Task name cannot be empty.";
    }
}
?>

<h2>Update Task</h2>
<?php if (isset($error_message)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
<?php endif; ?>
<form method="post" action="update_task.php?id=<?php echo urlencode($task_id); ?>">
    <input type="text" name="task_name" value="<?php echo htmlspecialchars($task['task_name']); ?>" required><br>
    <button type="submit">Update Task</button>
</form>
<?php include 'includes/footer.php'; ?>
