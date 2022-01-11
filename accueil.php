<?php
session_start();
if(isset($_SESSION['user'])){
    $connection = new PDO('mysql:host=localhost;dbname=stock','root','');    
    $resultat = $connection->prepare("SELECT * FROM produit JOIN categorie
    ON produit.id_cat = categorie.id_cat WHERE produit.id_cat = ?");
    $resultat2 = $connection->query("SELECT * FROM categorie
    WHERE id_cat = ANY (SELECT id_cat FROM produit );");
    $active = true;
    if(isset($_POST['submit'])){
        $indice = $_POST['recherche'];
        if(!empty($indice)){            
            $active = false;
            $recherche = $connection->query("SELECT * FROM produit 
            WHERE reference = '$indice' OR ( libelle like '".$indice."%' )");
            //nombre des produits
            $nbproduit = $connection->query("SELECT COUNT(reference) AS nb FROM produit 
            WHERE ( libelle like '".$indice."%' ) OR reference = '$indice' ;");
            $nb = $nbproduit->fetch();
        }
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
    <title>Accueil</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <header>
        <?php include "source/header.php" ?> 
    </header> 
    <main id="home">
        <section class="home">
            <div class="home-text">
                <h1><span>Mon</span><span>Stock</span></h1>
                <h3>Pour une meilleure<br>gestion de stock</h3>
                <a href="#home-body" class="btn">Voir les produits</a>
            </div>
            <div class="home-img">
                <img src="images/home.png" alt="">
            </div>
            <img src="images/hometest.png" alt="">
        </section>

        <section id="home-body">
            <section class="menu" id="menu">
                <form method="POST" class="recherche-bar" id="recherche-menu">
                    <input type="search" name="recherche" id="recherche" value="<?php 
                        if(isset($_POST['submit']) && !empty($indice)){
                            echo $indice;
                        }  ?>" placeholder="Rechercher par le nom/la référence">
                    <button class="btn" type="submit" name="submit"><i class="fas fa-search"></i>Rechercher</button>
                </form>
                <img src="images/iconlamp.png" alt="">
                
                <?php if(isset($_POST['submit']) && !empty($indice)){ ?>
                <div id="search-info"><?php echo $nb['nb']?> produit(s) a/ont été trouvé(s)</div>

                <div class="box-container">
                    <?php while($row = $recherche->fetch()){?>
                    <div class="box">
                        <div class="box-img">
                            <img  src="<?='images/'.$row['img']?>" alt="">
                            <span class="quantite <?php if($row['quantite'] == 0 )echo 'red'?>"><?php echo $row['quantite']?></span>
                        </div>
                        <div class="box-content">
                            <div class="name-price">
                                    <h3><?php echo $row['libelle']?></h3>
                                    <span><?php echo $row['prix_vente']?>Dhs</span>
                                </div>
                            <div class="unitaire_achat">
                                <p>Prix unitaire : <?php echo $row['prix_unitaire']?> Dhs</p>
                                <p>Prix d'achat : <?php echo $row['prix_achat']?> Dhs</p>
                            </div>
                            <div class="actions">
                                <a href="modifyproduit.php?reference=<?php echo $row['reference'] ?>&id_cat=<?php echo $row['id_cat'] ?>"><i class="fas fa-edit edit"></i></a> 
                                <a onclick="return confirm('Êtes-vous sûr(e) de vouloir supprimer le produit ?')" href="source/remove.php?id=<?php echo $row['reference']?>"><i class="fas fa-trash-alt delete"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php } }?>  
                </div>
            </section>

            <?php 
                if ($active === true) {
                while($rows = $resultat2->fetch() ) {?>
                <section class="menu" id="menu">
                    <div class="cat-name">
                        <h2><?php echo $rows['nom_cat'].' :'?></h2>
                    </div>
                    <div class="box-container">
                        <?php 
                        $resultat->execute(array($rows['id_cat']));
                        while($row = $resultat->fetch()){
                        ?>
                        <div class="box">
                            <div class="box-img">
                                <img src="<?='images/'.$row['img']?>" alt="">
                                <span class="quantite <?php if($row['quantite'] == 0 )echo 'red'?>"><?php echo $row['quantite']?></span>
                            </div>
                            <div class="box-content">
                                <div class="name-price">
                                    <h3><?php echo $row['libelle']?></h3>
                                    <span><?php echo $row['prix_vente']?> Dhs</span>
                                </div>
                                <div class="unitaire_achat">
                                    <p>Prix unitaire : <?php echo $row['prix_unitaire']?> Dhs</p>
                                    <p>Prix d'achat : <?php echo $row['prix_achat']?> Dhs</p>
                                </div>
                                <div class="actions">
                                    <a href="modifyproduit.php?reference=<?php echo $row['reference'] ?>&id_cat=<?php echo $row['id_cat'] ?>"><i class="fas fa-edit edit"></i></a> 
                                    <a onclick="return confirm('Êtes-vous sûr(e) de vouloir supprimer le produit ?')" href="source/remove.php?id=<?php echo $row['reference']?>"><i class="fas fa-trash-alt delete"></i></a>
                                </div>
                            </div>
                        </div>
                        <?php } ?> 
                    <div>       
                </section>
            <?php }} ?>
        </section>
    </main>
<script src="JS/scrollreal.js"></script>
<script src="JS/main.js"></script>
</body>
</html>