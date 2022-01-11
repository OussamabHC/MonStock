<?php
    $connection = new PDO('mysql:host=localhost;dbname=stock','root','');    
    $id_app = $_POST['id_app'];
    $quantite = $_POST['quantite'];
    $reference = $_POST['reference'];
    $add1 = $connection->query("UPDATE produit SET produit.quantite = produit.quantite + '$quantite' WHERE reference = $reference");
    $add = $connection->query("INSERT INTO `quantite_app` (`quantite`, `reference`, `id_app`) VALUES ('$quantite','$reference','$id_app')");
    header('location:../addProduitProvision.php?id_app='.$id_app);
?>


