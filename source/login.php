<?php
    $user=$_GET["user"];
    $pass=$_GET["pass"];
$connection = new PDO('mysql:host=localhost;dbname=stock','root','');    
$resultat = $connection->query("SELECT * FROM admins WHERE username ='$user' AND password = '$pass'");
$row = $resultat->fetch();
if($row['username'] == $user && $row['password'] == $pass){
    $_SESSION['user'] = $user;
    header('location:../accueil.php');
}else{
    header('location:../index.php');
}





    // //username
    // if(empty($user)){
    //     $errer['userempty'] = 'Veuillez remplir ce champ !';
    // }else{
    //     $errer['userempty'] = '';
    // }
    // //password
    // if(empty($pass)){
    //     $errer['passempty'] = 'Veuillez remplir ce champ !';
    // }else{
    //     $errer['passempty'] = '';
    // }