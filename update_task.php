<?php
require 'includes/db.php';
include 'includes/header.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$task_id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$task_id, $user_id]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    echo "Task not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = $_POST['task_name'] ?? '';

    $stmt = $pdo->prepare("UPDATE tasks SET task_name = ? WHERE id = ?");
    $stmt->execute([$task_name, $task_id]);

    header('Location: dashboard.php');
    exit();
}
?>

<div class="update-task-form">
    <h2>Update Task</h2>
    <form method="post" action="update_task.php?id=<?php echo $task_id; ?>">
        <input type="text" name="task_name" value="<?php echo htmlspecialchars($task['task_name']); ?>" required>
        <button type="submit">Update Task</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
