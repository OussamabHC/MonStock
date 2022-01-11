<?php
$id_com = $_GET['id_com'];
$reference = $_GET['reference'];
$connection = new PDO('mysql:host=localhost;dbname=stock','root',''); 
$resultat1 = $connection->query("UPDATE produit
SET produit.quantite = produit.quantite + ( SELECT quantite FROM quantite
WHERE quantite.reference = '$reference' AND quantite.id_com = '$id_com')
WHERE produit.reference = '$reference';");
$resultat = $connection->query("DELETE FROM `quantite` 
WHERE `quantite`.`reference` = $reference AND `quantite`.`id_com` = $id_com");
header('location:../addProduitCommande.php?id_com='.$id_com);
?>