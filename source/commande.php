<?php
    $client = $_POST['client'];
    $connection = new PDO('mysql:host=localhost;dbname=stock','root','');    
    $resultat = $connection->query("INSERT INTO commande (`date_com`, `id_cli`)  
    VALUES ( now(),'$client');");
    $id_commande = $connection->query("SELECT id_com FROM commande ORDER BY id_com DESC limit 1");
    $commande = $id_commande->fetch();
    $id_format = number_format($commande['id_com']);
    header('location:../addProduitCommande.php?id_com='.$id_format);
?>