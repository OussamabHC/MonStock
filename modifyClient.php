<?php
session_start();
if(isset($_SESSION['user'])){
    $id_cli = $_GET['id_cli'];
    $connection = new PDO('mysql:host=localhost;dbname=stock','root','');
    $resultat = $connection->query("SELECT * FROM client WHERE id_cli = '$id_cli'");
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
    <title>Modification du client</title>
    
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <header>
        <?php include "source/header.php"?>
    </header>
    <main class="addclisection">
        <form action="source/updateclient.php" method="POST" id="addcliform">
            <h2>Modifier le client :</h2>
            <input type="number" name="id_cli" id="id_cli" value="<?php echo $row['id_cli']?>" hidden>
            <div class="input-container">
                <label for="nom">nom</label><input type="text" name="nom" id="nom" value="<?php echo $row['nom']?>"></div>
            <div class="input-container">
                <label for="numero">n° téléphone</label><input type="number" name="numero" id="numero" value="<?php echo $row['numero']?>"></div>
            <div class="input-container">
                <label for="email">email</label><input type="email" name="email" id="email" value="<?php echo $row['email']?>"></div>
            <div class="input-container">
                <label for="adresse">adresse</label><input type="text" name="adresse" id="adresse" value="<?php echo $row['adresse']?>"></div>
            <input class="btn" type="submit" name="submit" value="Enregistrer">
        </form>
    </main>
</body>
</html>
