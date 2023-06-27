<!-- Traitement du formulaire de signalement-->
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
        $data_signalement= $check->fetch();
        $row = $check->rowCount();
        
        if($row > 0){
            $nombre_signalement=$data_signalement['nombre_signalement'];
            $nombre_signalement++;
        }
        else
        {
            $nombre_signalement=1;
        }

        if($nombre_signalement > 3){
            header('Location:annonce_suppression.php?id='.$id_annonce.'&ori=signalement'); die();
        }
        else{
            $check = $bdd->prepare('DELETE FROM signalement WHERE id_annonce = ?');
            $check->execute(array($id_annonce));

            $insert = $bdd->prepare('INSERT INTO signalement(id_annonce, nombre_signalement) VALUES(:id_annonce, :nombre_signalement)');
            $insert->execute(array(
            'id_annonce' => $id_annonce,
            'nombre_signalement' => $nombre_signalement
            ));
            header('Location:annonce_detail.php?id='.$id_annonce); die();
        }
    }

?>