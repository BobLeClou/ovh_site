<!DOCTYPE html>
<html lang="fr">
<?php session_start(); ?>
<head>
  <meta charset="UTF-8">
  <title>Livre d'Or</title>
  <link rel="stylesheet" href="/css/style-global.css">
  <link rel="stylesheet" href="/css/style-buttons.css">
  <link rel="stylesheet" href="/css/style-dashboard.css">
</head>

<script>
  const textarea = document.getElementById('texte');
  const charCount = document.getElementById('charCount');

  textarea.addEventListener('input', () => {
    const currentLength = textarea.value.length;
    const maxLength = textarea.getAttribute('maxlength');
    charCount.textContent = `${currentLength} / ${maxLength}`;
  });
</script>

<body>

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/navbar.php';?>

  <h1>Livre d'Or</h1>

  <form method="POST" action="/goldenbook/submit.php">
    <input type="text" name="name" is="name" placeholder="Nom" required><br>
    <textarea name="text" id="text" placeholder="Message" rows="4" maxlength="250" required></textarea><br>
    <div style="text-align: right; font-size: 12px; color: #333;">
      <span id="charCount">0 / 250</span>
    </div>
    <button type="submit">Envoyer</button>
  </form>

  <div id="messages">
    <h2>Messages :</h2>
    <?php include '/goldenbook/message.php'; ?>
  </div>

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';?>

</body>
</html>
