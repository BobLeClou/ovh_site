<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

try {
    $db = new PDO('sqlite:' . __DIR__ . '/../database/message.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $nom = $_POST['name'] ?? '';
    $texte = $_POST['text'] ?? '';

    if (trim($nom) && trim($texte)) {
        $stmt = $db->prepare('INSERT INTO messages (nom, texte) VALUES (:nom, :texte)');
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':texte', $texte, PDO::PARAM_STR);
        $stmt->execute();
    }

    header("Location: goldenbook.php");
    exit;
} catch (PDOException $e) {
    // Afficher l'erreur
    echo "Erreur : " . $e->getMessage();
    // Ou logger l'erreur
    error_log("Erreur base de données : " . $e->getMessage());
}
?>