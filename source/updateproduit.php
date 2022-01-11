<?php
$reference = $_POST['reference'];
$libelle = $_POST['libelle'];
$prix_unitaire = $_POST['prix_unitaire'];
$quantite = $_POST['quantite'];
$prix_achat = $_POST['prix_achat'];
$prix_vente = $_POST['prix_vente'];
$categorie = $_POST['categorie'];
$connection = new PDO('mysql:host=localhost;dbname=stock','root','');
$resultat = $connection->query("UPDATE `produit` SET `libelle` = '$libelle', `prix_unitaire` = '$prix_unitaire', `quantite` = '$quantite', `prix_achat` = '$prix_achat', `prix_vente` = '$prix_vente', `id_cat` = '$categorie' WHERE `produit`.`reference` = '$reference';
");
header('location:../accueil.php');
?>
