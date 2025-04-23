<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

try {
    $db = new PDO('sqlite:' . __DIR__ . '/../database/message.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $nom = $_POST['nom'] ?? '';
    $texte = $_POST['texte'] ?? '';

    if (trim($nom) && trim($texte)) {
        $stmt = $db->prepare('INSERT INTO messages (nom, texte) VALUES (:nom, :texte)');
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':texte', $texte, PDO::PARAM_STR);
        $stmt->execute();
    }

    header("Location: /goldenbook/goldenbook.php");
    exit;
    }
?>