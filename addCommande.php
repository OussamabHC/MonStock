<?php 
session_start();
if(isset($_SESSION['user'])){
    $connection = new PDO('mysql:host=localhost;dbname=stock','root','');    
    $resultat = $connection->query("SELECT * FROM client");

    if(isset($_POST['submit']) && !empty($_POST['recherche'])){
        $indice = $_POST['recherche'];
        $resultat3 = $connection->query("SELECT * FROM commande JOIN client 
        ON commande.id_cli = client.id_cli
        WHERE ( nom like '".$indice."%' ) OR client.id_cli = '$indice'
        ORDER BY id_com DESC;");
        //nombre des commandes
        $nbcommande = $connection->query("SELECT COUNT(id_com) AS nb FROM commande JOIN client 
        ON commande.id_cli = client.id_cli 
        WHERE ( client.nom like '".$indice."%' ) OR client.id_cli = '$indice' ;");
        $nb = $nbcommande->fetch();
    }else{
        $resultat3 = $connection->query("SELECT * FROM commande JOIN client 
        ON commande.id_cli = client.id_cli
        ORDER BY id_com DESC;"); 
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
    <title>Ajout des commandes</title>
    
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body> 
    <header>
        <?php include "source/header.php"?>
    </header>
    <main class="addcomsection">
        <form method="POST" class="recherche-bar">
            <input type="search" name="recherche" id="recherche" value="<?php 
                if(isset($_POST['submit']) && !empty($_POST['recherche'])){
                    echo $indice ;
                }  ?>" placeholder="Rechercher par le nom / l'id du client">
            <button class="btn" type="submit" name="submit"><i class="fas fa-search"></i>Rechercher</button>
        </form>

        <?php if(isset($_POST['submit']) && !empty($_POST['recherche'])){ ?>
        <div><?php echo $nb['nb']?> commande(s) a/ont été trouvé(s)</div>

        <section id="cli">
        <?php while($rows = $resultat3->fetch()) {?>
                <div class="cli-container">
                    <div class="side1">
                        <img src="images/iconorder.png" alt="">
                        <div><?php echo $rows['nom'] ?> </div>
                    </div>
                    <div class="side2">
                        <div>
                            <p>ID commande :&#160;</p><p><?php echo $rows['id_com'] ?> </p>
                        </div>
                        <div>
                            <p>Date :&#160;</p><p><?php echo $rows['date_com'] ?> </p>
                        </div> 
                        <div class="actions">
                            <a href="addProduitCommande.php?id_com=<?php echo $rows['id_com']?>"><i class="fas fa-edit edit"></i></a> 
                            <a onclick="return confirm('Êtes-vous sûr(e) de vouloir supprimer la commande ?')" href="source/dropCommande.php?id_com=<?php echo $rows['id_com']?>" ><i class="fas fa-trash-alt delete"></i></a>
                        </div>  
                    </div>
                </div> 
            <?php } ?> 
        </section>
        <?php }else{ ?>

        <form action="source/commande.php" method="POST" id="addcomform">
            <h2>Ajouter une commande :</h2>
            <div class="input-container">
                <label for="client">client</label>
                <select name="client" id="client" required>
                <option value="" disabled selected>Choisir le client</option>
                <?php while($row = $resultat->fetch()) {?>
                    <option value="<?php echo $row['id_cli']  ?>">
                        <?php echo $row['nom'] ?>
                    </option>
                <?php } ?>
                </select>
            </div>
            <input class="btn" type="submit" name="submit" value="Enregistrer">
        </form>
        <?php } ?>
        </div>
    </main>
<script src="JS/scrollreal.js"></script>
<script src="JS/main.js"></script>
</body>
</html>