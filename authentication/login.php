<?php
session_start();

$message = '';

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $db = new PDO('sqlite:' . __DIR__ . '/../database/user.db');

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare('SELECT id, password, role FROM users WHERE username = :username');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Authentification réussie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];

            // Redirection vers une page sécurisée
            header('Location: /index.php');
            exit;
        } else {
            $message = 'Nom d\'utilisateur ou mot de passe incorrect.';
        }
    } catch (PDOException $e) {
        $message = 'Erreur de connexion : ' . $e->getMessage();
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

    <h2>Connexion</h2>
    <?php if (!empty($message)) : ?>
        <p style="color: red;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form action="/authentication/login.php" method="post">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Se connecter</button>
    </form>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';?>

</body>
</html>
