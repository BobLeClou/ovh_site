<?php
try {
    $db = new PDO('sqlite:' . __DIR__ . '/../database/message.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $db->query('SELECT id, nom, texte, date FROM messages ORDER BY date DESC');
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($messages as $row) {
        $date = date('d/m/Y à H:i', strtotime($row['date']));
        $nom = htmlspecialchars($row['nom']);
        $texte = htmlspecialchars($row['texte']);
        $id = $row['id'];

        echo "<div class='msg'>
                <p><span class='nom'>$nom</span> a dit :</p>
                <p style='font-style: italic; color: darkmagenta;'>\"$texte\"</p>
                <p style='font-size: 12px; color: gray;'>🕒 $date</p>
                <form method='post' action='/authentication/delete.php' onsubmit=\"return confirm('Supprimer ce message ?');\">
                    <input type='hidden' name='id' value='$id'>
                    <button type='submit'>🗑️ Supprimer</button>
                </form>
              </div>";
    }
} catch (PDOException $e) {
    echo "<p>Erreur lors du chargement des messages : " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
