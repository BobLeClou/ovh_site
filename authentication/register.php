<?php
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $defaultRole = 'user';

        try {
            $db = new PDO('sqlite:' . __DIR__ . '/../database/user.db');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', $defaultRole);
            $stmt->execute();

            // Redirection vers la page de login
            header('Location: /authentication/login.php');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $message = "Ce nom d'utilisateur est déjà utilisé.";
            } else {
                $message = "Erreur : " . $e->getMessage();
            }
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="/css/style-global.css">
    <link rel="stylesheet" href="/css/style-buttons.css">
    <link rel="stylesheet" href="/css/style-auth.css">
</head>

<body>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/navbar.php';?>

    <h2>Créer un compte</h2>
    <?php if (!empty($message)) : ?>
        <p style="color: red;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form action="register.php" method="post">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">S'inscrire</button>
    </form>
    <p>Déjà inscrit ? <a href="/authentication/login.php">Se connecter</a></p>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';?>

</body>
</html>
