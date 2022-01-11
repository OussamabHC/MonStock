<?php
session_start();
if(isset($_SESSION['user'])){
    $id_app = $_GET['id_app'];
    $connection = new PDO('mysql:host=localhost;dbname=stock','root',''); 

    // 
    $resultat = $connection->query("SELECT * FROM approvisionnement JOIN fournisseur 
    ON approvisionnement.id_four = fournisseur.id_four
    WHERE  approvisionnement.id_app = '$id_app';");
    $row = $resultat->fetch();

    // //
    // $resultat3 = $connection->query("SELECT id_app,quantite_app.quantite as 'quantite' , produit.reference as 'reference' , libelle , nom_cat ,prix_achat FROM quantite_app JOIN produit JOIN categorie
    // ON quantite_app.reference = produit.reference AND produit.id_cat = categorie.id_cat
    // WHERE quantite_app.id_app = '$id_app';");

    //
    $resultat2 = $connection->query("SELECT * FROM produit 
    WHERE produit.reference != ALL( SELECT quantite_app.reference
    FROM quantite_app
    WHERE id_app = '$id_app');");

    //nombre de produit qui restent
    $deja = $connection->query("SELECT COUNT(reference) AS nb FROM produit
    WHERE produit.quantite > 0 AND  produit.reference != ALL( SELECT quantite_app.reference
    FROM quantite_app
    WHERE quantite_app.id_app = '$id_app');");
    $x = $deja->fetch();
    $cmp = number_format($x['nb']);

    //table
    $resultat3 = $connection->query("SELECT * FROM approvisionnement JOIN produit JOIN quantite_app JOIN categorie
    ON approvisionnement.id_app = quantite_app.id_app AND produit.reference = quantite_app.reference AND produit.id_cat = categorie.id_cat
    WHERE quantite_app.id_app = '$id_app';");
    $somme = 0;

// if (isset($_POST['submit1'])) {
//     $quantite = $_POST['quantite'];
//     $reference = $_POST['reference'];
//     $add = $connection->query("INSERT INTO `quantite_app` (`quantite_app`, `reference_produit`, `id_approvisionnement`) VALUES ('$quantite','$reference','$id_app')");
// }
}else{
    header('location:index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infos approvisionnement</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
<header>
        <?php include "source/header.php"?>
</header>
<main>
    <section>
        <div class="information">
            <div class="info"><span>ID approvisionnement :</span><span>  <?php echo $row['id_app']?></span></div>
            <div class="info"><span>Date d'approvisionnement :</span><span>  <?php echo $row['date_app'] ?></span></div>
            <div class="info"><span>Nom du fournisseur :</span><span>  <?php echo $row['nom']?></span></div>
            <div class="info"><span>Numéro du fournisseur :</span><span>  <?php echo $row['numero']?></span></div>
            <div class="info"><span>Email du fournisseur :</span><span>  <?php echo $row['email']?></span></div>
            <div class="info"><span>Adresse du fournisseur :</span><span>  <?php echo $row['adresse']?></span></div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Quantité</th>
                    <th>Libellé</th>
                    <th>Categorié</th>
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
                    <td><?php echo $row3['quantite'] * $row3['prix_achat'].' Dhs'?></td>
                    <td> 
                        <a onclick="return confirm('Êtes-vous sûr(e) de vouloir supprimer le produit de l\'approvisionnement ?')" href="source/dropApprovisionProd.php?id_app=<?php echo $row3['id_app']?>&reference=<?php echo $row3['reference']?>" ><i class="fas fa-trash-alt delete"></i></a>
                    </td>
                </tr>
                <?php $somme = $somme + $row3['quantite'] * $row3['prix_achat']; } ?>
            </tbody>
        </table>
        <p class="somme"> Prix total : <?php echo $somme ?> Dhs</p>
    </section>

    <?php if($cmp > 0 ){?>
    <form action="source/quantite_app.php" method="POST" id="addprodcomform">
        <div><input type="number" value="<?php echo $id_app ?>" name="id_app" hidden >
            <div class="input-container">
                <label for="reference" id="reference">produit</label>
                <select name="reference" required>
                    <option value="" disabled selected>Choisir le produit</option>
                    <?php while($rows = $resultat2->fetch()) {?>
                    <option value="<?php echo $rows['reference']?>">
                        <?php echo $rows['libelle'].' | Quantité : '.$rows['quantite'].' => '.$rows['prix_achat'].' Dhs'?>
                    </option>
                    <?php } ?>
                </select>
            </div>
            <div class="input-container">
                <label for="quantite">quantité</label><input type="number" name="quantite" id="quantite" placeholder="Entrer la quantite" required>
            </div>
        </div>
        <input class="btn" type="submit" name="submit" value="Ajouter">
    </form>
    <?php } else {?>
        <br>
        <p class="note">Tous les produits sont déjà ajoutés à l'approvisionnement !</p>
    <?php } ?>
</main>
<script src="JS/main.js"></script>
</body>
</html>