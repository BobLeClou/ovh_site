<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Test OK<br>";

$db = new PDO('sqlite:' . __DIR__ . '/../database/message.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo "Connexion OK<br>";


echo "Affichage des messages";
$stmt = $db->query('SELECT * FROM messages');
echo "fin des messages";
echo "Requête OK<br>";