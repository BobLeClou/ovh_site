<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id']; // Sécurise l'entrée

    $db = new SQLite3('/database/message.db');
    $stmt = $db->prepare('DELETE FROM messages WHERE id = :id');
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $stmt->execute();
}

header('Location: /goldenbook/goldenbook.php'); // Retour à la page principale
exit;
?>
