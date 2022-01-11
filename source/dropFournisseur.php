<?php
$id_four = $_GET['id_four'];
$connection = new PDO('mysql:host=localhost;dbname=stock','root','');  
$resultat = $connection->query("DELETE FROM fournisseur
WHERE id_four = '$id_four' ");
header('location:../fournisseur.php');
?>
