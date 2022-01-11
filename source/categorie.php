<?php
    $connection = new PDO('mysql:host=localhost;dbname=stock','root','');    
    $nom = $_POST['nom_cat'];
    if(!empty($nom)){
        $resultat = $connection->query("INSERT INTO `categorie` ( `nom_cat`) VALUES ('$nom');");
    }
    header('location:../addCategorie.php');
?>
