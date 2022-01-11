<?php
session_start();
if(isset($_SESSION['user'])){
    $reference = $_GET['reference'];
    $categorie = $_GET['id_cat'];
    $connection = new PDO('mysql:host=localhost;dbname=stock','root','');
    $resultat = $connection->query("SELECT * FROM produit NATURAL JOIN categorie WHERE reference = '$reference'");
    $resultat1 = $connection->query("SELECT * FROM categorie WHERE id_cat != '$categorie' ");
    $row = $resultat->fetch();
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
    <title>Modification du produit</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <header>
    <?php include "source/header.php" ?> 
    </header> 
    <main class="addclisection" style="background: url('images/bg8.png') no-repeat bottom center/100% auto;">
        <form action="source/updateproduit.php" method="post" enctype="multipart/form-data" id="addcliform">
            <h2>Modifier le produit :</h2>
            <input type="number" name="reference" id="reference" value="<?php echo $row['reference']?>" hidden>
            <div class="input-container">
                <label for="libelle">libellé</label><input type="text" name="libelle" id="libelle" value="<?php echo $row['libelle']?>">
            </div>
            <div class="input-container">
                <label for="prix_unitaire">prix unitaire</label><input type="number" min="0" name="prix_unitaire" id="prix_unitaire" value="<?php echo $row['prix_unitaire']?>">
            </div>
            <div class="input-container">
                <label for="quantite">quantite initiale</label><input type="number" min="0" name="quantite" id="quantite" value="<?php echo $row['quantite']?>">
            </div>
            <div class="input-container">
                <label for="prix_achat">prix d'achat</label><input type="number" min="0" name="prix_achat" id="prix_achat" value="<?php echo $row['prix_achat']?>">
            </div>
            <div class="input-container">
                <label for="prix_vente">prix de vente</label><input type="number" min="0" name="prix_vente" id="prix_vente" value="<?php echo $row['prix_vente']?>">
            </div>
            <div class="input-container">
                <label for="categorie">catégorie</label>
                    <select name="categorie" id="categorie">
                        <option value="<?php echo $row['id_cat']?>" selected><?php echo $row['nom_cat']?></option>
                        <?php while($rows = $resultat1->fetch()) {?>
                        <option value="<?php echo $rows['id_cat']  ?>">
                            <?php echo $rows['nom_cat'] ?>
                        </option>
                    <?php } ?>
                </select>
                </div>
            <input class="btn" id="Enregistrement" type="submit" name="submit" value="Enregistrer">
        </form>
    </main>
</body>
</html>