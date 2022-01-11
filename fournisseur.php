<?php 
session_start();
if(isset($_SESSION['user'])){
    $connection = new PDO('mysql:host=localhost;dbname=stock','root','');
    if(isset($_POST['submit']) && !empty($_POST['recherche'])){
        $indice = $_POST['recherche'];
        $resultat = $connection->query("SELECT * FROM fournisseur 
        WHERE ( nom like '".$indice."%' ) OR id_four = '$indice' 
        ORDER BY id_four DESC");
        //nombre des fournisseurs
        $nbfournisseur = $connection->query("SELECT count(id_four) AS nb FROM fournisseur 
        WHERE ( nom like '".$indice."%' ) OR id_four = '$indice' ;");
        $nb = $nbfournisseur->fetch();
    }else{
        $resultat = $connection->query("SELECT * FROM fournisseur ORDER BY id_four DESC");
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
    <title>Ajout des fournisseurs</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <header>
        <?php include "source/header.php"?>
    </header>    
    <main class="addfoursection">
        <form method="POST" class="recherche-bar">
            <input type="search" name="recherche" id="recherche" value="<?php 
                if(isset($_POST['submit']) && !empty($_POST['recherche'])){
                    echo $indice ;
                }  ?>" placeholder="Rechercher par le nom / l'id">
            <button class="btn" type="submit" name="submit"><i class="fas fa-search"></i>Rechercher</button>
        </form>

        <?php if(isset($_POST['submit']) && !empty($_POST['recherche'])){ ?>
        <div><?php echo $nb['nb']?> fournisseur(s) a/ont été trouvé(s)</div>

        <section id="cli">
        <?php while($rows = $resultat->fetch()) {?>
            <div class="cli-container">
                <div class="side1">
                    <?php if($rows['sexe'] === "Masculin"){ ?>
                    <img src="images/iconmale1.png" alt=""> 
                    <?php } else {?>
                    <img src="images/iconfemale1.png" alt=""> <?php } ?>
                    <p><?php echo $rows['nom'] ?> </p>
                </div>
                <div class="side2">
                    <div>
                        <p>ID fournisseur :&#160;</p><p> <?php echo $rows['id_four'] ?> </p>
                    </div>
                    <div>
                        <p>N° téléphone :&#160;</p><p> <?php echo $rows['numero'] ?> </p> 
                    </div>
                    <div>
                        <p>Email :&#160;</p><p> <?php echo $rows['email'] ?> </p> 
                    </div>
                    <div>
                        <p>Adresse :&#160;</p><p> <?php echo $rows['adresse'] ?></p>
                    </div>

                    <div class="actions">
                        <a href="modifyFournisseur.php?id_four=<?php echo $rows['id_four']?>"><i class="fas fa-edit edit"></i></a> 
                        <a onclick="return confirm('Êtes-vous sûr(e) de vouloir supprimer le fournisseur ?')" href="source/dropFournisseur.php?id_four=<?php echo $rows['id_four']?>"><i class="fas fa-trash-alt delete"></i></a>
                    </div>  
                </div>
            </div> 
        <?php } ?> 
        </section>

        <?php } else { ?>
        <form action="source/fournisseur.php" method="POST" id="addcliform">
            <h2>Ajouter un fournisseur :</h2>
            <div class="input-container">
                <label for="nom">nom</label><input type="text" name="nom" id="nom" placeholder="Entrer le nom" required></div>
            <div class="input-container">
                <label for="numero">n° téléphone</label><input type="number" name="numero" id="numero" placeholder="Entrer le numéro du téléphone" required></div>
            <div class="input-container">
                <label for="email">email</label><input type="email" name="email" id="email" placeholder="Entrer l'adresse email" required></div>
            <div class="input-container">
                <label for="sexe">sexe</label>
                <select name="sexe" id="sexe" required>
                    <option value="" disabled selected>Choisir le sexe</option>
                    <option value="Masculin">Masculin</option>
                    <option value="Féminin">Féminin</option>
                </select>
            </div>
            <div class="input-container">
            <label for="adresse">adresse</label><input type="text" name="adresse" id="adresse" placeholder="Entrer l'adresse" required></div>
            <input class="btn" type="submit" name="submit" value="Enregistrer">
        </form>
        <?php } ?>
    </main>
<script src="JS/scrollreal.js"></script>
<script src="JS/main.js"></script>
</body>
</html>