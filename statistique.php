<?php
session_start();
if(isset($_SESSION['user'])){
    $connection = new PDO('mysql:host=localhost;dbname=stock','root',''); 
    //les 10 produit qui ont le plus grand de qauntite de demander    
    $bestquantite = $connection->query("SELECT produit.reference AS reference ,libelle ,SUM(quantite.quantite) AS somme FROM produit JOIN quantite
    ON produit.reference = quantite.reference
    GROUP BY produit.reference
    ORDER BY SUM(quantite.quantite) DESC;");

    //trie par le plus demander   
    $bestcommander = $connection->query("SELECT produit.reference AS reference ,libelle,count(quantite.quantite) AS somme FROM produit JOIN quantite
    ON produit.reference = quantite.reference
    GROUP BY produit.reference
    ORDER BY count(quantite.quantite) DESC;");

    //trie par les bénéfices
    $benefices = $connection->query("SELECT commande.date_com AS date,SUM(quantite.quantite) AS somme ,SUM((produit.prix_vente - produit.prix_achat ) * quantite.quantite) AS benefice
    FROM produit JOIN quantite JOIN commande
    ON produit.reference = quantite.reference AND quantite.id_com = commande.id_com
    GROUP BY  commande.date_com
    ORDER BY commande.date_com DESC ");

    //nombre des clients
    $nbclient = $connection->query("SELECT COUNT(id_cli) AS nb FROM client");

    //nombre des fournisseurs
    $nbfournisseur = $connection->query("SELECT COUNT(id_four) AS nb FROM fournisseur");

    //nombre des catégories
    $nbcategorie = $connection->query("SELECT COUNT(id_cat) AS nb FROM categorie");

    //nombre des commandes
    $nbcommandeparjour = $connection->query("SELECT date_com,COUNT(id_com) AS nb FROM commande 
    GROUP BY date_com ORDER BY date_com DESC");

    //nombre des approvisionnements
    $nbaprovisionparjour = $connection->query("SELECT date_app,COUNT(id_app) AS nb FROM  approvisionnement GROUP BY date_app ORDER BY date_app DESC");

    // les produits ont une quantité "null"
    $quantite = $connection->query("SELECT * FROM produit WHERE quantite = 0");
    $nbproduit = $connection->query("SELECT count(reference) as nb FROM produit ");
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
    <title>Statistiques</title>
    
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/statistique.css">
       <style>
        table { 
            margin-bottom: 150px;
            margin-top: -30px;
        }
        table th , table td {
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <?php include "source/header.php" ?>
    </header>
    <main class="statistique">
        <div class="title">
            <h2>Quelques Statistiques :</h2>
        </div>
        <div id="cat">
            <div class="cat-container">
                <img src="images/iconmale.png" alt="">
                <div>
                    <span><?php echo $nbclient->fetch()['nb'] ?></span>
                    <span>Client(s)</span>
                </div>
            </div>
            <div class="cat-container">
                <img src="images/iconmale1.png" alt="">
                <div>
                    <span><?php echo $nbfournisseur->fetch()['nb'] ?></span>
                    <span>Fournisseur(s)</span>
                </div>
            </div>
            <div class="cat-container">
                <img src="images/iconcat.png" alt="">
                <div>
                    <span><?php echo $nbcategorie->fetch()['nb'] ?></span>
                    <span>Catégorie(s)</span>
                </div>
            </div>
            <div class="cat-container">
                <img src="images/iconprod.png" alt="">
                <div>
                    <span><?php echo $nbproduit->fetch()['nb'] ?></span>
                    <span>Produit(s)</span>
                </div>
            </div>
        </div>

        <!-- Piechart -->
        <div id="piechart"></div>  

        <!-- endcharts  -->
        <table>
        <h2>Les bénéfices</h2>
            <thead>
                <tr>
                    <th>Date</th> 
                    <th>Quantité totale</th> 
                    <th>Bénéfices</th> 
                </tr>
            </thead>
            <tbody>
            <?php while($bc = $benefices->fetch()){ ?>
                    <tr>
                        <td><?php echo $bc['date'] ?> </td>
                        <td><?php echo $bc['somme'] ?> </td>
                        <td><?php echo $bc['benefice'] ?> Dhs </td> 
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <table>
        <h2>N° des commandes/jour</h2>
            <thead>
                <tr>
                    <th>Date</th> 
                    <th>Commandes</th>
                </tr>
            </thead>
            <tbody>
            <?php while($ncpj = $nbcommandeparjour->fetch()){ ?>
                    <tr>
                        <td><?php echo $ncpj['date_com'] ?> </td>
                        <td><?php echo $ncpj['nb'] ?> </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <table>
        <h2>N° d'approvisionnements/jour</h2>
            <thead>
                <tr>
                    <th>Date</th> 
                    <th>Approvisionnements</th>
                </tr>
            </thead>
            <tbody>
            <?php while($napj = $nbaprovisionparjour->fetch()){ ?>
                    <tr>
                        <td><?php echo $napj['date_app'] ?> </td>
                        <td><?php echo $napj['nb'] ?> </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <table>
        <h2>Les produits indisponibles en stock</h2>
            <thead>
                <tr>
                    <th>Référence</th> 
                    <th>Libellé</th> 
                    <th>Quantité</th> 
                </tr>
            </thead>
            <tbody>
            <?php while($q = $quantite->fetch()){?>
                    <tr>
                        <td><?php echo $q['reference'] ?> </td>
                        <td><?php echo $q['libelle'] ?> </td>
                        <td><?php echo $q['quantite'] ?> </td> 
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <table>
        <h2>Les produits les plus demandés</h2>
            <thead>
                <tr>
                    <th>Référence</th> 
                    <th>Libellé </th> 
                    <th>Quantité</th> 
                </tr>
            </thead>
            <tbody>
            <?php while($bq = $bestquantite ->fetch()){ ?>
                    <tr>
                        <td><?php echo $bq['reference'] ?> </td>
                        <td><?php echo $bq['libelle'] ?> </td>
                        <td><?php echo $bq['somme'] ?> </td> 
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <table>
        <h2>Les produits les plus commandés</h2>
            <thead>
                <tr>
                    <th>Référence</th> 
                    <th>Libellé </th> 
                    <th>Commandes</th> 
                </tr>
            </thead>
            <tbody>
            <?php while($bc = $bestcommander ->fetch()){ ?>
                    <tr>
                        <td><?php echo $bc['reference'] ?> </td>
                        <td><?php echo $bc['libelle'] ?> </td>
                        <td><?php echo $bc['somme'] ?> </td> 
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ['students', 'contribution'],
        <?php
        $con = mysqli_connect("localhost","root","","stock");
        $sql = "SELECT nom_cat,SUM(quantite) AS quantite 
        FROM produit join categorie 
        ON produit.id_cat = categorie.id_cat
        GROUP BY categorie.id_cat;";
        $fire = mysqli_query($con,$sql);
        while ($result = mysqli_fetch_assoc($fire)) {
            echo"['".$result['nom_cat']."',".$result['quantite']."],";
        }
        ?>
        ]);
        var options = {
            title: 'Votre Stock :'
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
    google.charts.load('upcoming', {'packages': ['vegachart']}).then(drawChart);
    </script>
<script src="JS/scrollreal.js"></script>
<script src="JS/main.js"></script>
</body>
</html>
