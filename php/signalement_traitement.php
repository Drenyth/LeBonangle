<?php
    require_once 'config.php';

    if(isset($_GET['id'])){
        $id_annonce = $_GET['id'];
    }    
    if(!empty($_COOKIE['userid']))
    {
        $userid = $_COOKIE['userid'];
        $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
        $req->execute(array($userid));
        $data = $req->fetch();

        $password = $data['password'];
        $date_creation = $data['date_inscription'];
        $token = $data['token'];
        $ip = $data['ip'];
    }
    else
    {
        $userid = false;
    }
    if(!empty($id_annonce)){
        //recuperation des donnes de l'annonce
        $check = $bdd->prepare('SELECT * FROM signalement WHERE id_annonce = ?');
        $check->execute(array($id_annonce));
        $data= $check->fetch();

        $nombre_signalement=$data['nombre_signalement'];

        if($nombre_signalement == 3){
            header('Location:annonce_modification.php?modif_err=annonce_length&id='.$id_annonce); die();
        }
        elseif($nombre_signalement<= 3){
            $nombre_signalement++;
            $insert1 = $bdd->prepare('INSERT INTO signalement (id_annonce,nombre_signalement) 
            VALUES(:id_annonce, :signalement)');
            $insert1->execute(array(
            'id_annonce' => $id_annonce,
            'nombre_signalement' => $nombre_signalement
            ));
        }
    }

?>