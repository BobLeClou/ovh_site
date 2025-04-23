<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
echo "Erreur suppression : " . $e->getMessage();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];

    try {
        $db = new PDO('sqlite:' . __DIR__ . '/../database/message.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare('DELETE FROM messages WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
}

header('Location: goldenbook.php');
exit;
}
?>
