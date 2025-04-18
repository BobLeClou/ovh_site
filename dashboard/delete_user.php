<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: /index.php");
    exit;
}

$id = $_POST['id'] ?? null;
if (!$id) {
    exit("ID manquant");
}
$db = new PDO('sqlite:' . __DIR__ . '/../database/user.db');


// Récupérer infos de la cible
$stmt = $db->prepare("SELECT username, role FROM users WHERE id = ?");
$stmt->execute([$id]);
$target = $stmt->fetch(PDO::FETCH_ASSOC);

// Empêcher les suppressions interdites
if (!$target) {
    exit("Utilisateur introuvable.");
}

$self = $_SESSION['username'];
$role = $_SESSION['role'];
$targetRole = $target['role'];
$targetUser = $target['username'];

$canDelete = false;
if ($target['role'] === 'administrator' && $role === 'administrator' && $targetUser !== $self) {
    exit("Impossible de supprimer un autre administrateur.");
}
if ($role === 'administrator' && $targetRole !== 'administrator') {
    $canDelete = true;
}
if ($role === 'moderator' && $targetRole === 'user') {
    $canDelete = true;
}

if ($canDelete) {
    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: /dashboard/dashboard.php");
} else {
    exit("Action non autorisée.");
}
