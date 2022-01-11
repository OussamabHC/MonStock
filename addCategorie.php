<?php
session_start();
if(isset($_SESSION['user'])){
$connection = new PDO('mysql:host=localhost;dbname=stock','root','');
$resultat = $connection->query("SELECT * FROM categorie ORDER BY id_cat DESC");

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
    <title>Ajout des catégories</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <header>
        <?php include "source/header.php" ?>
    </header>    
    <main class="addcatsection">
        <form action="source/categorie.php" method="POST" id="addcatform">
            <h2>Ajouter une catégorie :</h2>
            <div class="input-container">
                <label for="nom_cat">catégorie</label><input type="text" name="nom_cat" id="nom_cat" placeholder="Entrer le nom de la catégorie">
            </div>
            <input class="btn" type="submit" name="submit" value="Enregistrer">
        </form>
        
        <section id="cat">
        <?php while($rows = $resultat->fetch()) {?>
            <div class="cat-container">
                <div class="side1">
                    <i class="fas fa-store-alt"></i>
                    <p><?php echo $rows['nom_cat']?></p>
                </div>
                <div class="side2">
                    <a href="modifycategorie.php?id_cat=<?php echo $rows['id_cat']?>"><i class="fas fa-edit edit"></i></a> 
                    <a onclick="return confirm('Êtes-vous sûr(e) de vouloir supprimer la catégorie ?')" href="source/dropcategorie.php?id_cat=<?php echo $rows['id_cat']?>"><i class="fas fa-trash-alt delete"></i></a>
                </div>
            </div>
        <?php } ?>
        </section>
    </main>
<script src="JS/scrollreal.js"></script>
<script src="JS/main.js"></script>
</body>
</html>
