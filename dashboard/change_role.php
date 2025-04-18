<?php
session_start();
if ($_SESSION['role'] !== 'administrator') {
    header("Location: /index.php");
    exit;
}

$id = $_POST['id'] ?? null;
$newRole = $_POST['role'] ?? null;

if (!$id || !in_array($newRole, ['user', 'moderator'])) {
    exit("Rôle invalide");
}

$db = new PDO('sqlite:' . __DIR__ . '/../database/user.db');
$stmt = $db->prepare("UPDATE users SET role = :role WHERE id = :id AND role != 'administrator'");
$stmt->execute([
    ':role' => $newRole,
    ':id' => $id
]);

header("Location: /dashboard/dashboard.php");
