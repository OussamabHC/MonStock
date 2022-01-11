<?php
$id_cat = $_GET['id_cat'];
$connection = new PDO('mysql:host=localhost;dbname=stock','root','');  
$resultat = $connection->query("DELETE FROM categorie
WHERE id_cat = '$id_cat' ");
header('location:../addCategorie.php');
?>

