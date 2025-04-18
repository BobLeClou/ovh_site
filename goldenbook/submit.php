<?php
$db = new SQLite3('/database/message.db');

$nom = $_POST['nom'] ?? '';
$texte = $_POST['texte'] ?? '';

if (trim($nom) && trim($texte)) {
    $stmt = $db->prepare('INSERT INTO messages (nom, texte) VALUES (:nom, :texte)');
    $stmt->bindValue(':nom', $nom, SQLITE3_TEXT);
    $stmt->bindValue(':texte', $texte, SQLITE3_TEXT);
    $stmt->execute();
}

header("Location: /goldenbook/goldenbook.php");
exit;
?>