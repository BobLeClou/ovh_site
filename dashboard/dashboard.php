<?php
session_start();

// Redirection si pas connecté ou pas modo/admin
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['administrator', 'moderator'])) {
    header("Location: /index.php");
    exit;
}

$db = new PDO('sqlite:' . __DIR__ . '/../database/user.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupération des utilisateurs
$users = $db->query("SELECT id, username, role FROM users ORDER BY username ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="/css/style-global.css">
  <link rel="stylesheet" href="/css/style-buttons.css">
  <link rel="stylesheet" href="/css/style-dashboard.css">
</head>

<body>
 
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/navbar.php';?>

  <h1>Tableau de bord</h1>
  <?php if ($_SESSION['role'] === 'administrator'): ?>
    <div style="margin-top: 40px; padding: 20px; border: 2px dashed red; background-color: #ffeeee;">
      <h2>⚠️ Zone de danger : Réinitialisation des bases de données</h2>
      <form method="post">
        <button type="submit" name="reset_db" onclick="return confirm('Es-tu sûr ? Cela va TOUT supprimer.')">
          🔥 Supprimer et recréer les bases
        </button>
      </form>
    </div>

    <?php
    if (isset($_POST['reset_db'])) {
      if (file_exists('/../data/message.db')) unlink('/../data/message.db');
      if (file_exists('/../data/user.db')) unlink('/../data/user.db');
      include('/../init_db.php');
      echo "<p style='color: green;'>✅ Bases supprimées et recréées avec succès.</p>";
    }
    ?>
  <?php endif; ?>


  <?php foreach ($users as $user): ?>
    <div class="user-row">
      <div><strong><?= htmlspecialchars($user['username']) ?></strong> (<?= $user['role'] ?>)</div>
      <div class="user-actions">
        <?php
          $canDelete = false;
          $canEditRole = false;
          $sessionRole = $_SESSION['role'];

          if ($sessionRole === 'administrator') {
              if ($user['role'] !== 'administrator' || $user['username'] === $_SESSION['username']) {
                  $canDelete = $user['username'] !== $_SESSION['username'];
                  $canEditRole = $user['role'] !== 'administrator';
              }
          } elseif ($sessionRole === 'moderator') {
              if (!in_array($user['role'], ['administrator', 'moderator'])) {
                  $canDelete = true;
              }
          }
        ?>

        <?php if ($canDelete): ?>
          <form method="post" action="/dashboard/delete_user.php" onsubmit="return confirm('Supprimer cet utilisateur ?');">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <button type="submit">❌</button>
          </form>
        <?php endif; ?>

        <?php if ($canEditRole): ?>
          <form method="post" action="/dashboard/change_role.php">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <select name="role" onchange="this.form.submit()">
              <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>user</option>
              <option value="moderator" <?= $user['role'] === 'moderator' ? 'selected' : '' ?>>moderator</option>
            </select>
          </form>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';?>

</body>
</html>
