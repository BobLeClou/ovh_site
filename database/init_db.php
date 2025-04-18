<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Initialisation de la base</title>
  <link rel="stylesheet" href="/style.css">
</head>
<body>

<h1>📦 Initialisation des bases de données</h1>

<?php
try {
    $db_message = new SQLite3(__DIR__ . '/message.db');
    $db_message->exec("CREATE TABLE IF NOT EXISTS messages (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nom TEXT NOT NULL,
        texte TEXT NOT NULL,
        date DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    echo "<div class='success'>✅ Base <strong>message.db</strong> créée (ou déjà existante).</div>";

    $db_user = new SQLite3(__DIR__ . '/user.db');
    $db_user->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        role TEXT NOT NULL CHECK(role IN ('user', 'administrator', 'moderator')),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    $adminPassword = password_hash('bonjour', PASSWORD_BCRYPT);
    $userPassword = password_hash('bonjour', PASSWORD_BCRYPT);

    $db_user->exec("INSERT INTO users (username, password, role) VALUES 
        ('admin', '$adminPassword', 'administrator'),
        ('user', '$userPassword', 'user')");

    echo "<div class='success'>✅ Base <strong>user.db</strong> créée avec utilisateurs initiaux.</div>";
} catch (Exception $e) {
    echo "<p style='color: red;'>Erreur : " . $e->getMessage() . "</p>";
}
?>

<a class="button" href="/index.php">🏠 Retour à l'accueil</a>

</body>
</html>
