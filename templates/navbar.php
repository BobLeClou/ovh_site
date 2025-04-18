
<?php
session_start();
$role = $_SESSION['role'] ?? null;
$username = $_SESSION['username'] ?? null;
?>
<nav style="background-color: #222; color: white; padding: 10px;">
    <a href="/index.php" style="color: white; margin-right: 15px;">Accueil</a>
    <?php if (!$username): ?>
        <a href="/authentication/login.php" style="color: white; margin-right: 15px;">Connexion</a>
        <a href="/authentication/register.php" style="color: white;">Inscription</a>
    <?php else: ?>
        <span style="margin-right: 15px;">Connecté en tant que <?= htmlspecialchars($username) ?></span>
        <a href="/authentication/logout.php" style="color: white; margin-right: 15px;">Déconnexion</a>
        <?php if ($role === 'administrator' || $role === 'moderator'): ?>
            <a href="/dashboard/dashboard.php" style="color: white;">Dashboard</a>
        <?php endif; ?>
    <?php endif; ?>
</nav>
