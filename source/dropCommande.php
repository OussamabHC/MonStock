<?php
$id_com = $_GET['id_com'];
$connection = new PDO('mysql:host=localhost;dbname=stock','root','');  
$resultat = $connection->query("DELETE FROM `commande`
WHERE id_com = '$id_com' ");
header('location:../addCommande.php');
?>