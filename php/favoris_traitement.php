<?php 
require_once "config.php";

if(!empty($_COOKIE['userid']))
{
    $userid = $_COOKIE['userid'];

    /* requête pour avoir les données de l'utilisateur */
    $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
    $req->execute(array($userid));
    $data = $req->fetch();
}
else{header('Location:annonce_detail.php?id='.$id_annonce.'&reg_err=error');die;}

if(isset($_GET['id_annonce'])){
    $id_annonce = $_GET['id_annonce'];
    $check_favoris = $bdd->prepare('SELECT * FROM favoris WHERE id_utilisateur = ? and id_annonce = ?');
    $check_favoris->execute(array($userid,$id_annonce));
    $row_data_favoris = $check_favoris->rowCount();

    if($row_data_favoris == 0){
        $insert = $bdd->prepare('INSERT INTO favoris(id_utilisateur, id_annonce) VALUES(:id_utilisateur, :id_annonce)');
        $insert->execute(array(
        'id_utilisateur' => $userid,
        'id_annonce' => $id_annonce
        ));
        header('Location:annonce_detail.php?id='.$id_annonce.'&reg_err=success');
        die;
    }
    else{header('Location:annonce_detail.php?id='.$id_annonce.'&reg_err=already');die;}
}else{header('Location:annonce_detail.php?id='.$id_annonce.'&reg_err=error'); die;}