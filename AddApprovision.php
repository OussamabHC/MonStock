<?php 
session_start();
if(isset($_SESSION['user'])){
    $connection = new PDO('mysql:host=localhost;dbname=stock','root','');
    $resultat = $connection->query("SELECT * FROM fournisseur");

    if(isset($_POST['submit']) && !empty($_POST['recherche'])){
        $indice = $_POST['recherche'];
        $resultat3 = $connection->query("SELECT * FROM approvisionnement JOIN fournisseur 
        ON approvisionnement.id_four = fournisseur.id_four
        WHERE ( nom like '".$indice."%' ) OR  fournisseur.id_four = '$indice' 
        ORDER BY id_app DESC  ;");
        //nombre des approvisionnements
        $nbappro = $connection->query("SELECT COUNT(id_app) AS nb FROM approvisionnement JOIN fournisseur 
        ON approvisionnement.id_four = fournisseur.id_four
        WHERE ( fournisseur.nom like '".$indice."%' ) OR fournisseur.id_four = '$indice' ;");
        $nb = $nbappro->fetch();
    }else{
        $resultat3 = $connection->query("SELECT * FROM approvisionnement JOIN fournisseur 
        ON approvisionnement.id_four = fournisseur.id_four
        ORDER BY id_app DESC  ;"); 
    }
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
    <title>Ajout des approvisionnements</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body> 
    <header>
        <?php include "source/header.php"?>
    </header>
    <main class="addappsection">
        <form method="POST" class="recherche-bar">
            <input type="search" name="recherche" id="recherche" value="<?php 
                if(isset($_POST['submit']) && !empty($_POST['recherche'])){
                    echo $indice ;
                }  ?>" placeholder="Rechercher par le nom / l'id du fournisseur">
            <button class="btn" type="submit" name="submit"><i class="fas fa-search"></i>Rechercher</button>
        </form>

        <?php if(isset($_POST['submit']) && !empty($_POST['recherche'])){ ?>
        <div><?php echo $nb['nb']?> approvisionnement(s) a/ont été trouvé(s)</div>

        <section id="cli">
            <?php while($rows = $resultat3->fetch()) {?>
            <div class="cli-container">
                <div class="side1">
                    <img src="images/iconapp.png" alt="">
                    <div><?php echo $rows['nom'] ?> </div>
                </div>
                <div class="side2">
                    <div>
                        <p>ID approvisionnement :&#160;</p><p><?php echo $rows['id_app'] ?> </p>
                    </div>
                    <div>
                        <p>Date :&#160;</p><p><?php echo $rows['date_app'] ?> </p>
                    </div> 
                    <div class="actions">
                        <a href="addProduitProvision.php?id_app=<?php echo $rows['id_app']?>"><i class="fas fa-edit edit"></i></a> 
                        <a onclick="return confirm('Êtes-vous sûr(e) de vouloir supprimer l\'approvisionnement ?')" href="source/dropProvision.php?id_app=<?php echo $rows['id_app']?>" ><i class="fas fa-trash-alt delete"></i></a>
                    </div>  
                </div>
            </div> 
            <?php } ?> 
        </section>
        <?php }else { ?>

        <form action="source/approvision.php" method="POST" id="addcomform">
            <h2>Ajouter un approvisionnement :</h2>
            <div class="input-container">
                <label for="fournisseur">fournisseur</label>
                <select name="fournisseur" id="fournisseur">
                <option value="" disabled selected>Choisir le fournisseur</option>
                <?php while($row = $resultat->fetch()) {?>
                    <option value="<?php echo $row['id_four'] ?>">
                        <?php echo $row['nom'] ?>
                    </option>
                <?php } ?>
                </select>
            </div>
            <input class="btn" type="submit" name="submit" value="Enregistrer">
        </form>
        <?php }?>
    </main>
<script src="JS/scrollreal.js"></script>
<script src="JS/main.js"></script>
</body>
</html>
