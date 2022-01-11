<?php 
session_start();
if(isset($_SESSION['user'])){
    $connection = new PDO('mysql:host=localhost;dbname=stock','root','');
    $resultat = $connection->query("SELECT * FROM categorie");
} else{
    header('location:index.php');
}   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout des produits</title>

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
    <main class="addprodsection">
        <form action="source/produit.php" method="POST" enctype="multipart/form-data">
            <div id="addprodform">
                <h2>Ajouter un produit :</h2>
                <div class="input-container">
                    <label for="libelle">libellé</label><input type="text" name="libelle" id="libelle" placeholder="Entrer le libellé"placeholder="Entrer le libellé" required>
                </div>
                <div class="input-container">
                    <label for="prix_unitaire">prix unitaire</label><input type="number" min="0" name="prix_unitaire" id="prix_unitaire" placeholder="Entrer le prix unitaire" required>
                </div>
                <div class="input-container">
                    <label for="quantite">quantite initiale</label><input type="number" min="0" name="quantite" id="quantite" placeholder="Entrer la quantité initiale" required>
                </div>
                <div class="input-container">
                    <label for="prix_achat">prix d'achat</label><input type="number" min="0" name="prix_achat" id="prix_achat" placeholder="Entrer le prix d'chat" required>
                </div>
            </div>

            <div id="addprodform">
                <div class="input-container">
                    <label for="prix_vente">prix de vente</label><input type="number" min="0" name="prix_vente" id="prix_vente" placeholder="Entrer le prix de vente" required>
                </div>
                <div class="input-container">
                <label for="categorie">catégorie</label>
                    <select name="categorie" id="categorie" required>
                        <option value="" disabled selected>Choisir la catégorie</option>
                    <?php while($row = $resultat->fetch()) {?>
                        <option value="<?php echo $row['id_cat']  ?>">
                            <?php echo $row['nom_cat'] ?>
                        </option>
                    <?php } ?>
                </select>
                <!--<label for="img">Entrer l'image</label>-->
                </div>
                <div class="input-container">
                    <label for="img">photo du produit</label><input type="file" name="img" id="img" required>
                </div>
                <input class="btn" id="Enregistrement" type="submit" name="submit" value="Enregistrer">
            </div>
        </form>
    </main>
<script src="JS/scrollreal.js"></script>
<script src="JS/main.js"></script>
</body>
</html>
