<?php
require 'includes/db.php';
include 'includes/header.php';

// Start the session
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ?");
$stmt->execute([$user_id]);
$tasks = $stmt->fetchAll();
?>

<h2>Your Tasks</h2>
<a href="add_task.php">Add Task</a> | <a href="logout.php">Logout</a>
<ul>
    <?php foreach ($tasks as $task): ?>
        <li class="<?php echo $task['completed'] ? 'completed' : ''; ?>">
            <?php echo htmlspecialchars($task['task_name']); ?>
            <?php if (!$task['completed']): ?>
                [<a href="complete_task.php?id=<?php echo $task['id']; ?>">Complete</a>]
                [<a href="update_task.php?id=<?php echo $task['id']; ?>">Update</a>]
            <?php endif; ?>
            [<a href="delete_task.php?id=<?php echo $task['id']; ?>">Delete</a>]
        </li>
    <?php endforeach; ?>
</ul>

<?php include 'includes/footer.php'; ?>
