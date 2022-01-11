<?php
$nom = $_POST['nom'];
$numero = $_POST['numero'];
$email = $_POST['email'];
$sexe = $_POST['sexe'];
$adresse = $_POST['adresse'];
$connection = new PDO('mysql:host=localhost;dbname=stock','root','');    
$resultat = $connection->query("INSERT INTO `fournisseur` ( `nom`, `numero`, `email`,` sexe`, `adresse`) VALUES 
('$nom','$numero','$email','$sexe','$adresse');");
header('location:../fournisseur.php');
?>