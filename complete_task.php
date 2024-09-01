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

$stmt = $pdo->prepare("UPDATE tasks SET completed = TRUE WHERE id = ? AND user_id = ?");
$stmt->execute([$task_id, $user_id]);

header('Location: dashboard.php');
exit();
?>
