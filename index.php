<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Site immonde</title>
  <link rel="stylesheet" href="/css/style-global.css">
  <link rel="stylesheet" href="/css/style-buttons.css">
</head>

<script>
  function afficherOui() {
    document.getElementById("content").innerHTML = `
      <h1>Comment ca ?</h1>
      <p style="font-size: 30px;">Evidemment que non, je n'ai rien a faire, pouruqoi ce site existe a ton avis bouffon</p>
    `;
  }

  function afficherNon() {
    document.getElementById("content").innerHTML = `
      <h1>Effectivement</h1>
      <p style="font-size: 30px;">je n'ai rien a faire, comme le prouve ce site de con la, merci papa gpt tu gère (tellement rien a faire que je fais meme pas le site moi meme)</p>
    `;
  }
</script>

<body>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/navbar.php';?>

<br><a href="/goldenbook/goldenbook.php"><button>Accès rapide au Livre d'Or</button></a><br>

<div id="content" class="container">
  <p>Test fonctionnement github action</p>
  <br>
  <h1>test</h1>
  <div class="button-group">
    <button onclick="afficherOui()">Oui</button>
    <button onclick="afficherNon()">Non</button>
  </div>
</div>


<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';?>

</body>
</html>
