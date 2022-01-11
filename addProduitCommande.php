<?php
session_start();
if(isset($_SESSION['user'])){
    $connection = new PDO('mysql:host=localhost;dbname=stock','root','');    
    $id_com = $_GET['id_com'];

    //afficher les produits qui restent, si un produit existe dans la commande donc il sera pas affiché
    $resultat1 = $connection->query("SELECT * FROM produit
    WHERE  produit.quantite > 0 AND  produit.reference != ALL( SELECT quantite.reference
    FROM quantite
    WHERE quantite.id_com = '$id_com');");
    
    //nombre des produits qui restent
    $deja = $connection->query("SELECT COUNT(reference) AS nb FROM produit
    WHERE produit.quantite > 0 AND  produit.reference != ALL( SELECT quantite.reference
    FROM quantite
    WHERE quantite.id_com = '$id_com');");
    $x = $deja->fetch();
    $cmp = number_format($x['nb']);

    //entete
    $resultat2  = $connection->query(" SELECT * FROM commande JOIN client
    ON commande.id_cli = client.id_cli
    WHERE commande.id_com = '$id_com' ");
    $row = $resultat2->fetch();
    
    //table
    $resultat3 = $connection->query("SELECT * FROM commande JOIN produit JOIN quantite JOIN categorie
    ON commande.id_com = quantite.id_com AND produit.reference = quantite.reference AND produit.id_cat = categorie.id_cat
    WHERE quantite.id_com = '$id_com';");
    $somme = 0;
}else{
    header('location:index.php');
}
?>

<!DOCTYPE html>
<html lang="en"  moznomarginboxes mozdisallowselectionprint>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infos commande</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- box icons link -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <header>
        <?php include "source/header.php"?>
    </header>
    <main>
        <section>
            <div class="pdf-header">
                <h2>Bon de commande :</h2>
                <img src="images/logo.png" alt="">
            </div>
            <div class="pdf-infos">
                <div class="company">
                    <p>Mon entreprise</p>
                    <p>891, avenue du Deux Mars</p>
                    <p>Casablanca, Maroc</p>
                    <p>Téléphone : +212 5 22 21 47 64</p>
                </div>
                <div class="recipient">
                    <p>Destinataire</p>
                    <p> <?php echo $row['nom'] ?> </p>
                    <p><?php echo $row['adresse'] ?> </p>
                    <p>Maroc</p>
                </div>
            </div>
            <div class="information">
                <div class="info"><span>ID Commande :</span><span>  <?php echo $row['id_com']?></span></div>
                <div class="info"><span>Date de la commande :</span><span>  <?php echo $row['date_com'] ?></span></div>
                <div class="info"><span>Nom du client :</span><span>  <?php echo $row['nom']?></span></div>
                <div class="info"><span>Numéro du client :</span><span>  <?php echo $row['numero']?></span></div>
                <div class="info"><span>Email du client :</span><span>  <?php echo $row['email']?></span></div>
                <div class="info"><span>Adresse du client :</span><span>  <?php echo $row['adresse']?></span></div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Quantité</th>
                        <th>Libellé</th>
                        <th>Catégorie</th>
                        <th>Prix final</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row3 = $resultat3->fetch()) {?>
                    <tr>
                        <td><?php echo $row3['reference'] ?></td>
                        <td><?php echo $row3['quantite'] ?></td>
                        <td><?php echo $row3['libelle'] ?></td>
                        <td><?php echo $row3['nom_cat'] ?></td>
                        <td><?php echo $row3['quantite'] * $row3['prix_vente'].' Dhs'?></td>
                        <td id="delete">
                            <a onclick="return confirm('Êtes-vous sûr(e) de vouloir supprimer le produit de la commande ?')" href="source/dropCommandeProd.php?id_com=<?php echo $row3['id_com']?>&reference=<?php echo $row3['reference']?>" ><i class="fas fa-trash-alt delete"></i></a>
                        </td>
                    </tr>
                    <?php $somme = $somme + $row3['quantite'] * $row3['prix_vente']; } ?>
                </tbody>
            </table>
            <p class="somme"><span>Prix total : </span> <?php echo $somme ?> Dhs</p>
        </section>

        <?php if($cmp > 0 ){?>
        <form action="source/quantite.php" method="POST" id="addprodcomform">
            <div><input type="number" value="<?php echo $id_com ?>" name="id_com" hidden >
                <div class="input-container">
                    <label for="reference" id="reference">produit</label>
                    <select name="reference" required>
                        <option value="" disabled selected>Choisir le produit</option>
                        <?php while($rows = $resultat1->fetch()) {?>
                        <option value="<?php echo $rows['reference']?>">
                            <?php echo $rows['libelle'].' | Quantité : '.$rows['quantite'].' => '.$rows['prix_vente'].' Dhs'?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-container">
                    <label for="quantite">quantité</label><input type="number" name="quantite" id="quantite" placeholder="Entrer la quantite" required>
                </div>
            </div>
            <div style="justify-content: space-around; width: 25%; margin: auto;" id="print">
                <input class="btn" type="submit" name="submit" value="Ajouter">
                <a class="btn" onclick="window.print()"><i class='bx bxs-printer'></i> Imprimer</a>
            </div>
        </form>
        <?php } else {?>
        <br>
        <p class="note">Tous les produits sont déjà ajoutés à la commande !</p>
        <div id="print">
            <a class="btn" onclick="window.print()"><i class='bx bxs-printer'></i> Imprimer</a>
        </div>
        <?php } ?>
        <p id="signature">Signature :</p>
    </main>
<script src="JS/main.js"></script>
</body>
</html>