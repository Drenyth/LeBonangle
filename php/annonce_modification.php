<?php
    require_once 'config.php';


    if(!empty($_COOKIE['userid']))
    {
        $userid = $_COOKIE['userid'];

    }
    else
    {
        $userid = false;
    }
    
    $id_annonce = $_POST['id_annonce']

    if(!empty($_POST['id_annonce']) && !empty($_POST['id_utilisateur']) && !empty($_POST['nom_annonce']) && !empty($_POST['photo']) && !empty($_POST['description']) && !empty($_POST['prix'])) && !empty($_POST['tags'])
    {
        $id_annonce = htmlspecialchars($_POST['id_annonce']);
        $id_utilisateur = htmlspecialchars($_POST['id_utilisateur']);
        $nom_annonce = htmlspecialchars($_POST['nom_annonce']);
        $photo = htmlspecialchars($_POST['photo']);
        $description = htmlspecialchars($_POST['description']);
        $prix = htmlspecialchars($_POST['prix']);
        $email = htmlspecialchars($_POST['email']);
        $adresse_postal = htmlspecialchars($_POST['adresse_postal']);
        $tags = htmlspecialchars($_POST['tags']);
    
        $check = $bdd->prepare('SELECT id_utilisateur, id_annonce  FROM annonce WHERE id_annonce = ?');
        $check->execute(array($id_annonce));
        $data = $check->fetch();
        $row = $check->rowCount();

        if($row != 0){
            $check = $bdd->prepare('DELETE FROM annonce WHERE id_annonce = ?');
            $check->execute(array($id_annonce));


            if(strlen($nom_annonce) <= 100){
                 if(strlen($description) <= 1000){
                     if(strlen($email) <= 100){
                          if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                              if(strlen($tags)<=1000){
    
    
                                $insert = $bdd->prepare('INSERT INTO annonce(id_annonce, id_utilisateur, nom_annonce, photo, description, prix, email, adresse_postal,tags) 
                                VALUES(:id_annonce, :id_utilisateur, :nom_annonce, :photo, :description, :prix, :email, :adresse_postal, :tags)');
                                $insert->execute(array(
                                'id_annonce' => $id_annonce,
                                'id_utilisateur' => $id_utilisateur,
                                'nom_annonce' => $nom_annonce,
                                'photo' => $photo,
                                'description' => $description,
                                'prix' => $prix,
                                'email' => $email,
                                'adresse_postal' => $adresse_postal,
                                'tags' => $tags,

                                ));
                                header('Location:testmodif.php?reg_err=success');
                                die();

                            }else{header('Location:testmodif.php?reg_err=tags_length')}
                         }else {header('Location:testmodif.phpp?reg_err=email'); die();}
                     }else {header('Location:modification.php?reg_err=email_length'); die();}
                }else {header('Location:modification.php?reg_err=description_length'); die();}
            }else {header('Location:modification.php?reg_err=first_name_length'); die();}
        }
    }
?>