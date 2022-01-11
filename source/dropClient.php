<?php
$id_cli = $_GET['id_cli'];
$connection = new PDO('mysql:host=localhost;dbname=stock','root','');  
$resultat = $connection->query("DELETE FROM client
WHERE id_cli = '$id_cli' ");
header('location:../client.php');
?>

