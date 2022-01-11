<?php
$id_four = $_POST['id_four'];
$nom = $_POST['nom'];
$numero = $_POST['numero'];
$email = $_POST['email'];
$adresse = $_POST['adresse'];
$connection = new PDO('mysql:host=localhost;dbname=stock','root','');  
$resultat = $connection->query("UPDATE `fournisseur` SET 
`nom` = '$nom', 
`numero` = '$numero', 
`email` = '$email', 
`adresse` = '$adresse' 
WHERE `fournisseur`.`id_four` = '$id_four';");
header('location:../fournisseur.php');
?>
