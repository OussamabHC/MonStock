<?php
$libelle = $_POST['libelle'];
$prix_unitaire = $_POST['prix_unitaire'];
$quantite = $_POST['quantite'];
$prix_achat = $_POST['prix_achat'];
$prix_vente = $_POST['prix_vente'];
$categorie = $_POST['categorie'];
echo $libelle.' '. $prix_achat .' '. $prix_unitaire  .' '. $prix_vente .' '. $quantite .' '. $categorie;
$img = $_FILES['img'];
$filename = $_FILES["img"]["name"];
$filetmpname = $_FILES["img"]["tmp_name"];
$filerror = $_FILES["img"]["error"];
if($filerror === 0){
    $file_ex =  pathinfo($filename , PATHINFO_EXTENSION);
    $file_ex_lc = strtolower($file_ex);
    $all_ex_po = array("jpg","png","jpeg");
    if(in_array($file_ex_lc,$all_ex_po)){
        $new_name = uniqid("IMG-",true).'.'.$file_ex;
        $img_upload_path = '../images/'.$new_name;
        move_uploaded_file($filetmpname,$img_upload_path);
        $connection = new PDO('mysql:host=localhost;dbname=stock','root','');
        $resultat = $connection->query("INSERT INTO `produit` ( `img`, `libelle`, `prix_unitaire`, `quantite`, `prix_achat`, `prix_vente`, `id_cat`) VALUES 
        ('$new_name','$libelle','$prix_unitaire','$quantite','$prix_achat','$prix_vente','$categorie');");
    }
}
header('location:../addProduit.php');
?>
