<?php
$id = $_GET['id'];
$connection = new PDO('mysql:host=localhost;dbname=stock','root','');  
$resultat = $connection->query("DELETE FROM produit
WHERE reference = '$id' ");
header('location:../accueil.php');


