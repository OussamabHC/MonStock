<?php
$id_app = $_GET['id_app'];
$reference = $_GET['reference'];
$connection = new PDO('mysql:host=localhost;dbname=stock','root','');  
$resultat1 = $connection->query("UPDATE produit
SET produit.quantite = produit.quantite - ( SELECT quantite
    FROM quantite_app
    WHERE quantite_app.reference = '$reference' AND quantite_app.id_app = '$id_app'                                     
    )
WHERE produit.reference = '$reference';");
$resultat = $connection->query("DELETE FROM `quantite_app` 
WHERE `quantite_app`.`reference` = $reference AND `quantite_app`.`id_app` = $id_app");
header('location:../addProduitProvision.php?id_app='.$id_app);
