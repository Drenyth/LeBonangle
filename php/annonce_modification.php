<?php
    require_once 'config.php';

    $id_annonce = $_GET['id'];

    if(!empty($_COOKIE['userid']))
    {
        
        $userid = $_COOKIE['userid'];
        require_once 'config.php';
        
        $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
        $req->execute(array($userid));
        $data = $req->fetch();

        if(!empty($id_annonce)){
            $check = $bdd->prepare('SELECT * FROM annonce WHERE id_annonce = ? AND id_utilisateur= ?');
            $check->execute(array($id_annonce,$userid));
            $data_annonce = $check->fetch();
            if ($data_annonce) {
                // Le fetch a réussi, vous pouvez accéder aux éléments du tableau
                $id_utilisateur = $data_annonce['id_utilisateur'];
                $nom_annonce = $data_annonce['nom_annonce'];
                $photo = $data_annonce['photo'];
                $description = $data_annonce['description'];
                $prix = $data_annonce['prix'];
                $email = $data_annonce['email'];
                $adresse_postal = $data_annonce['adresse_postal'];
                $tags = $data_annonce['tags'];

                // Gestion Bien ou Service 
                //Bien
                $check = $bdd->prepare('SELECT * FROM bien WHERE id_annonce = ?');
                $check->execute(array($id_annonce));
                $data_type_annonce = $check->fetch();
                $row_type = $check->rowCount();
                if($row_type != 0){
                    $typebien = $data_type_annonce['type'];
                    $etat = $data_type_annonce['etat'];
                    $typeannonce = "bien";
                }
                //Service
                else{
                    $check = $bdd->prepare('SELECT * FROM service WHERE id_annonce = ?');
                    $check->execute(array($id_annonce));
                    $data_type_annonce = $check->fetch();
                    $row_type = $check->rowCount();
                    if($row_type != 0){
                        $date = $data_type_annonce['date'];
                        $typeannonce ="service";
                    }
                    else {
                        // Le fetch n'a renvoyé aucun résultat (error debugging tool)
                        echo "Aucun bien ou service trouvée pour $nom_annonce";
                    }
                }
            } else {
                // Le fetch n'a renvoyé aucun résultat (error debugging tool)
                echo "Aucune annonce trouvée avec l'identifiant $id_annonce et id_utilisateur $userid";
            }
        }
        else{
            $id_annonce = false ;
        }
    }
    else
    {
        $userid = false;
    }
    
    if(!empty($_POST['nom_annonce']) && !empty($_POST['photo']) && !empty($_POST['description']) && !empty($_POST['prix']) && !empty($_POST['email']) && !empty($_POST['adresse_postal']) && !empty($_POST['tags']))
    {
        $nom_annonce = htmlspecialchars($_POST['nom_annonce']);
        $photo = htmlspecialchars($_POST['photo']);
        $description = htmlspecialchars($_POST['description']);
        $prix = htmlspecialchars($_POST['prix']);
        $email = htmlspecialchars($_POST['email']);
        $adresse_postal = htmlspecialchars($_POST['adresse_postal']);
        $tags = htmlspecialchars($_POST['tags']);
        $check = $bdd->prepare('SELECT nom_annonce FROM annonce WHERE id_annonce = ?');
        $check->execute(array($id_annonce));
        $data_annonce = $check->fetch();

        $row = $check->rowCount();
        $email = strtolower($email);

        
        $typeannonce = htmlspecialchars($_POST['typeannonce']);
        
        //si le variable bien existe 
        if($typebien){
            $typebien = htmlspecialchars($_POST['typebien']);
            $etat = htmlspecialchars($_POST['etat']);      
        }
        // sinon c'est un service
        else{
            $date = htmlspecialchars($_POST['date']);
            }   


            if(strlen($nom_annonce) <= 100){
                 if(strlen($description) <= 1000){
                     if(strlen($email) <= 100){
                          if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                              if(strlen($tags)<=1000){
                                //On supprime l'ancienne table
                                $check = $bdd->prepare('DELETE FROM annonce WHERE id_annonce = ?');
                                $check->execute(array($id_annonce));
                                //On crée la nouvelle table

                                $insert = $bdd->prepare('INSERT INTO annonce(id_annonce, id_utilisateur, nom_annonce, photo, description, prix, email, adresse_postal,tags) 
                                VALUES(:id_annonce, :id_utilisateur, :nom_annonce, :photo, :description, :prix, :email, :adresse_postal, :tags)');
                                $insert->execute(array(
                                'id_annonce' => $id_annonce,
                                'id_utilisateur' => $userid,
                                'nom_annonce' => $nom_annonce,
                                'photo' => $photo,
                                'description' => $description,
                                'prix' => $prix,
                                'email' => $email,
                                'adresse_postal' => $adresse_postal,
                                'tags' => $tags
                                ));
                                // si bien ou service on modifie la table correspondant 
                                if($typeannonce == "bien"){
                                    
                                    $check1 = $bdd->prepare('DELETE FROM bien WHERE id_annonce = ?');
                                    $check1->execute(array($id_annonce));

                                    $insert1 = $bdd->prepare('INSERT INTO bien(id_annonce, type, etat) 
                                    VALUES(:id_annonce, :type, :etat)');
                                    $insert1->execute(array(
                                    'id_annonce' => $id_annonce,
                                    'type' => $typebien,
                                    'etat' => $etat
                                    ));
                                    }
                                    // sinon c'est un service
                                elseif($typeannonce == "service"){

                                    $check1 = $bdd->prepare('DELETE FROM service WHERE id_annonce = ?');
                                    $check1->execute(array($id_annonce));

                                    $insert1 = $bdd->prepare('INSERT INTO service(id_annonce, date) 
                                    VALUES(:id_annonce, :date)');
                                    $insert1->execute(array(
                                    'id_annonce' => $id_annonce,
                                    'date' => $date
                                    ));
                                    }
                                    // erreur modification bien/service
                                        else{{header('Location:annonce_modification_traitement.php?reg_err=typeannonce'); die();}
                                    }  

                                        header('Location:annonce_modification_traitement.php?reg_err=success');die();
                                }else{header('Location:annonce_modification_traitement.php?reg_err=tags_length');die();}
                         }else {header('Location:annonce_modification_traitement.php?reg_err=email'); die();}
                     }else {header('Location:annonce_modification_traitement.php?reg_err=email_length'); die();}
                }else {header('Location:annonce_modification_traitement.php?reg_err=description_length'); die();}
            }else {header('Location:annonce_modification_traitement.php?reg_err=annonce_length'); die();}
    }
    //temp
    else {header('Location:annonce_modification_traitement.php?reg_err=void'); die();}
?>