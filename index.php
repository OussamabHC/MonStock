<?php
session_start();
    $user='';
    $erreur =array(
        'userempty' => '',
        'passempty' => '',
        'incorrecte' => ''
    );
if (isset($_POST["submit"])) {
    $user=$_POST["user"];
    $pass=$_POST["pass"];

    //username
    if(empty($user)){
        $erreur['userempty'] = '<i class="fas fa-exclamation-circle"></i>Veuillez remplir ce champ !';
    }else{
        $erreur['userempty'] = '';
    }
    //password
    if(empty($pass)){
        $erreur['passempty'] = '<i class="fas fa-exclamation-circle"></i>Veuillez remplir ce champ !';
    }else{
        $erreur['passempty'] = '';
    }
    if(!empty($user) && !empty($pass)){
        $connection = new PDO('mysql:host=localhost;dbname=stock','root','');    
        $resultat = $connection->query("SELECT * FROM admin WHERE username = '$user' AND password = '$pass'");
        $row = $resultat->fetch();
        if($row['username'] == $user && $row['password'] == $pass){
            $_SESSION['user'] = $user;
            header('location:accueil.php');
        }else{
            $erreur['incorrecte'] = 'Les informations sont incorrectes !';
        }
        }        
    }
if(isset($_GET['logout'])){
    session_destroy();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
        <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <!-- box icons link -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Connexion</title>
</head>
<body>
    <div class="form-bg">
        <form id="formlogin" action="index.php" method="POST">
            <i class="icon fas fa-lock"></i>
            <h2>Login</h2>
            <br>
            <?php if (isset($_POST["submit"]) &&  empty($user)) { ?>
            <p class="erreur"><?php echo  $erreur['incorrecte'] ?></p>
            <?php } ?>
            <div class="input-container">
                <label for="user"><i class='bx bxs-user'></i> username</label>
                <input name="user" type="text" value="<?php echo $user ?>" id="user" placeholder="Entrer votre nom d'utilisateur">
                <?php if (isset($_POST["submit"]) &&  empty($user)) { ?>
                <p class="erreur"><?php echo  $erreur['userempty'] ?></p>
                <?php } ?>
            </div>
            <div class="input-container">
                <label for="pass"><i class='bx bxs-lock' ></i> password</label>
                <input type="password" name="pass" id="pass" placeholder="Entrer votre mot de passe">
                <?php if (isset($_POST["submit"]) && empty($pass)) { ?>
                <p class="erreur"><?php echo  $erreur['passempty'] ?></p>
                <?php } ?>
            </div>

            <input class="btn" id="connexion" type="submit" name="submit" value="Se Connecter">
        </form>
        <img src="images/logo.png" alt="">
    </div>
</body>
</html>