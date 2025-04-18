<?php
$db = new SQLite3('/database/message.db');

$results = $db->query('SELECT id, nom, texte, date FROM messages ORDER BY date DESC');

while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
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
?>
