<?php
require 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->execute([$task_id, $_SESSION['user_id']]);
}

header('Location: dashboard.php');
exit();
?>
