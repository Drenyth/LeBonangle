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
        //requete recuperant les donnees correspondant a l'annonce et a l'utilisateur
        $check_favoris = $bdd->prepare('SELECT * FROM favoris WHERE id_utilisateur = ? and id_annonce = ?');
        $check_favoris->execute(array($userid,$id_annonce));
        $row_data_favoris = $check_favoris->rowCount();

        //si $row_data_favoris est >0 l'annonce est deja dans les favoris donc on ne l'ajoute pas
        if($row_data_favoris == 0){
            //ajout de l'annonce dans la table des favoris
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
?>