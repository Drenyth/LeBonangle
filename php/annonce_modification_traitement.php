<?php
    //Execution du fichier se connectant a la base de donnée
    require_once 'config.php';
    if(isset($_GET['id'])){
        $id_annonce = $_GET['id'];
    }

    //recuperation des donnees utilisateurs, necessaire pour le traitement de la modification de l'annonce
    if(!empty($_COOKIE['userid']))
    {
        $userid = $_COOKIE['userid'];
        
        //recuperation des donnees utilisateurs
        $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
        $req->execute(array($userid));
        $data = $req->fetch();

        if(!empty($id_annonce)){
            //recuperation des donnes de l'annonce
            $check = $bdd->prepare('SELECT * FROM annonce WHERE id_annonce = ? AND id_utilisateur= ?');
            $check->execute(array($id_annonce,$userid));
            $data_annonce = $check->fetch();
            if (!empty($data_annonce)) {
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
                        $date_fin =$data_type_annonce['date_fin'];
                        $typeannonce ="service";
                    }
                    else {
                        // Le fetch n'a renvoyé aucun résultat 
                        echo "Aucun bien ou service trouvée pour $nom_annonce";
                    }
                }
            } else {
                // Le fetch n'a renvoyé aucun résultat 
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

    if(!empty($_POST['nom_annonce']) && !empty($_POST['description']) && !empty($_POST['prix']) && !empty($_POST['email']) && !empty($_POST['adresse_postal']) && !empty($_POST['tags']))
    {
        $nom_annonce = htmlspecialchars($_POST['nom_annonce']);
        $photo = $_FILES['photo'];
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
        if(isset($typeannonce)){
            if($typeannonce == 'bien'){
            $typebien = htmlspecialchars($_POST['typebien']);
            $etat = htmlspecialchars($_POST['etat']);
            }
            else{
                $date = htmlspecialchars($_POST['date']);
                $date_fin = htmlspecialchars($_POST['date_fin']);
                }    
        }
        // sinon c'est un service
       

            //Verifications que les donnees soient en accord avec la base de donnée et valides
            if(strlen($nom_annonce) <= 100){
                 if(strlen($description) <= 1000){
                     if(strlen($email) <= 100){
                          if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                              if(strlen($tags)<=1000){
                                if(is_numeric($prix)){
                                    if ($photo['error'] === UPLOAD_ERR_OK) {

                                        $photo_name = $photo['name']; 
                                        $photo_tmp = $photo['tmp_name'];
                                        $destination = 'images_annonce/' . $photo_name;
                                        move_uploaded_file($photo_tmp, $destination);
            
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
                                        'photo' => $destination,
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

                                            $insert1 = $bdd->prepare('INSERT INTO bien (id_annonce, type, etat) 
                                            VALUES(:id_annonce, :type, :etat)');
                                            $insert1->execute(array(
                                            'id_annonce' => $id_annonce,
                                            'type' => $typebien,
                                            'etat' => $etat
                                            ));
                                            // Si passage d'un bien à une service
                                            $check2 = $bdd->prepare('DELETE FROM service WHERE id_annonce = ?');
                                            $check2->execute(array($id_annonce));
                                            }
                                            
                                            // sinon c'est un service
                                        elseif($typeannonce == "service"){

                                            $check1 = $bdd->prepare('DELETE FROM service WHERE id_annonce = ?');
                                            $check1->execute(array($id_annonce));

                                            $insert1 = $bdd->prepare('INSERT INTO service (id_annonce, date, date_fin) 
                                            VALUES(:id_annonce, :date, :date_fin)');
                                            $insert1->execute(array(
                                            'id_annonce' => $id_annonce,
                                            'date' => $date,
                                            'date_fin' => $date_fin
                                            ));
                                            // Si passage d'un service à un bien
                                            $check2 = $bdd->prepare('DELETE FROM bien WHERE id_annonce = ?');
                                            $check2->execute(array($id_annonce));
                                            }
                                            // erreur modification bien/service
                                                else{{header('Location:annonce_modification_traitement.php?modif_err=typeannonce&id='.$id_annonce); die();}
                                            }  

                                            header('Location:annonce_modification.php?modif_err=success&id='.$id_annonce);die();
                                        }else{header('Location:annonce_modification.php?modif_err=upload_error&id='.$id_annonce);die();}
                                    }else{header('Location:annonce_depot.php?modif_err=price&id='.$id_annonce);die();}
                                }else{header('Location:annonce_modification.php?modif_err=tags_length&id='.$id_annonce);die();}
                         }else {header('Location:annonce_modification.php?modif_err=email&id='.$id_annonce); die();}
                     }else {header('Location:annonce_modification.php?modif_err=email_length&id='.$id_annonce); die();}
                }else {header('Location:annonce_modification.php?modif_err=description_length&id='.$id_annonce); die();}
            }else {header('Location:annonce_modification.php?modif_err=annonce_length&id='.$id_annonce); die();}
    }
    //gestion erreurs

    else {header('Location:annonce_modification.php?modif_err=void&id='.$id_annonce); die();}

?>
