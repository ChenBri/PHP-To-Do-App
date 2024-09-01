<?php
// includes/db.php
$host = 'localhost';
$db = 'todo_app';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $err) {
    die("Error connecting to the database: " . $err->getMessage());
}
?>
