<?php
$id_app = $_GET['id_app'];
$connection = new PDO('mysql:host=localhost;dbname=stock','root','');  
$resultat = $connection->query("DELETE FROM `approvisionnement`
WHERE id_app = '$id_app' ");
header('location:../AddApprovision.php');
?>