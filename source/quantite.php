<?php
    $connection = new PDO('mysql:host=localhost;dbname=stock','root','');    
    $id_com = $_POST['id_com'];
    $quantite = $_POST['quantite'];
    $reference = $_POST['reference'];

    $select = $connection->query("SELECT quantite FROM produit WHERE reference = $reference");
    $select1 = $select->fetch();
    $quantite2 = number_format($select1['quantite']);

    if( $quantite <= $quantite2){
        $add1 = $connection->query("UPDATE produit SET produit.quantite = produit.quantite - '$quantite' WHERE reference = $reference");
        $add = $connection->query("INSERT INTO `quantite` (`quantite`, `reference`, `id_com`) VALUES ('$quantite','$reference','$id_com')");
    }
    header('location:../addProduitCommande.php?id_com='.$id_com);
?>
