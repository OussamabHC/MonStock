<?php
    $fournisseur = $_POST['fournisseur'];
    $connection = new PDO('mysql:host=localhost;dbname=stock','root','');    
    $resultat3 = $connection->query("INSERT INTO `approvisionnement` ( `date_app`, `id_four`)  
    VALUES (now(),'$fournisseur');");

    $id_commande = $connection->query("SELECT id_app FROM approvisionnement  ORDER BY id_app DESC limit 1");
    $commande = $id_commande->fetch();
    $id_format = number_format($commande['id_app']);
    header('location:../addProduitProvision.php?id_app='.$id_format);
    ?>
