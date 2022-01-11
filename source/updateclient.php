<?php
$id_cli = $_POST['id_cli'];
$nom = $_POST['nom'];
$numero = $_POST['numero'];
$email = $_POST['email'];
$adresse = $_POST['adresse'];
$connection = new PDO('mysql:host=localhost;dbname=stock','root','');  
$resultat = $connection->query("UPDATE `client` 
SET `nom` = '$nom', 
`numero` = '$numero', 
`email` = '$email', 
`adresse` = '$adresse'
WHERE `client`.`id_cli` = '$id_cli';");
header('location:../client.php');
?>