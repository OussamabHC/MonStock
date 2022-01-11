<?php
session_start();
if(isset($_SESSION['user'])){
    $id_cat = $_GET['id_cat'];
    $connection = new PDO('mysql:host=localhost;dbname=stock','root','');
    $resultat = $connection->query("SELECT * FROM categorie WHERE id_cat = '$id_cat'");
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
    <title>Modification de la catégorie</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <header >
        <?php include "source/header.php"?>
    </header>
    <main class="addcatsection">
        <form action="source/updatecategorie.php" method="POST" id="addcatform">
            <h2>Modifier la catégorie :</h2>
            <input type="number" name="id_cat" id="id_cat" value="<?php echo $row['id_cat']?>" hidden>
            <div class="input-container">
                <label for="nom_cat">catégorie</label><input type="text" name="nom_cat" id="nom_cat" value="<?php echo $row['nom_cat']?>" placeholder="Entrer le nouveau nom de la catégorie">
            </div>
            <input class="btn" type="submit" name="submit" value="Enregistrer">
        </form>
    </main>
</body>
</html>