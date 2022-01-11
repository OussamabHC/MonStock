<?php
$id_cat = $_POST['id_cat'];
$nom_cat = $_POST['nom_cat'];
$connection = new PDO('mysql:host=localhost;dbname=stock','root','');  
$resultat = $connection->query("UPDATE `categorie` SET `nom_cat` = '$nom_cat' WHERE `categorie`.`id_cat` = '$id_cat';");
header('location:../addCategorie.php');
?>