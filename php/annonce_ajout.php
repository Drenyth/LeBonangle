<!-- Traitement du formulaire de création d'une annonce-->
<?php
    //Execution du fichier se connectant a la base de donnée
    require_once 'config.php';

    if(!empty($_COOKIE['userid']))
    {
        $userid = $_COOKIE['userid'];

        //recuperation des données de l'utilisateur
        $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
        $req->execute(array($userid));
        $data = $req->fetch();
    }

    
    $annonce = htmlspecialchars($_POST['announcement']);
    $image = $_FILES['image']; 
    $desc = htmlspecialchars($_POST['description']);
    $price = htmlspecialchars($_POST['price']);
    $address = htmlspecialchars($_POST['adress']);
    $email = htmlspecialchars($_POST['mail']);
    $tags = htmlspecialchars($_POST['tags']);
    $typeannonce = htmlspecialchars($_POST['typeannonce']);
    $typebien = htmlspecialchars($_POST['typebien']);
    $etat = htmlspecialchars($_POST['etat']);
    $date = htmlspecialchars($_POST['date']);
    $date_fin = htmlspecialchars($_POST['date_fin']);

    //Verifications pour que les donnees soient en accord avec la base de donnée et valides
    if(strlen($desc) <= 1000){
        if(strlen($annonce) <= 100){
            if(strlen($email) <= 100){
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    if(is_numeric($price)){
                        if ($image['error'] === UPLOAD_ERR_OK) {

                            $image_name = $image['name'];
                            $image_tmp = $image['tmp_name'];
                            $destination = 'images_annonce/' . $image_name;
                            move_uploaded_file($image_tmp, $destination);
                            
                            //permet 
                            $email = strtolower($email);
                            //insertion des nouvelles données dans la base de donnée
                            $insert = $bdd->prepare('INSERT INTO annonce(nom_annonce, id_utilisateur, photo, description, prix, email, adresse_postal, tags) 
                                VALUES(:nom_annonce, :id_utilisateur, :photo, :description, :prix, :email, :adresse_postal, :tags)');
                            $insert->execute(array(
                                'nom_annonce' => $annonce,
                                'id_utilisateur' => $userid,
                                'photo' => $destination,
                                'description' => $desc,
                                'prix' => $price,
                                'email' => $email,
                                'adresse_postal' => $address,
                                'tags'=> $tags
                            ));
                            $id_annonce = $bdd->lastInsertId(); 

                            //Ajout de l'annonce dans la base de donnée corrrespondante au type de celle ci (bien ou service)
                            //Utile pour l'affichage des details de l'annonce (annonce_detail.php)
                            if($typeannonce == "bien"){
                                $insert2 = $bdd->prepare('INSERT INTO bien(etat, id_annonce, type)
                                    VALUES(:etat, :id_annonce, :type)');
                                $insert2->execute(array(
                                    'id_annonce' => $id_annonce,
                                    'etat'=>$etat,
                                    'type'=>intval($typebien),
                                ));
                            }else{
                                $insert2 = $bdd->prepare('INSERT INTO service(date, date_fin, id_annonce)
                                    VALUES(:date, :date_fin, :id_annonce)');
                                $insert2->execute(array(
                                    'date'=>$date,
                                    'id_annonce' => $id_annonce,
                                    'date_fin' => $date_fin
                                ));
                            }

                            header('Location:annonce_depot.php?reg_err=success');
                            die();
                        }else{header('Location: annonce_depot.php?reg_err=upload_error');die();}
                    }else{header('Location:annonce_depot.php?reg_err=price');die();}
                }else {header('Location:inscription.php?reg_err=email'); die();}
            }else {header('Location:inscription.php?reg_err=email_length'); die();}
        }else {header('Location:annonce_depot.php?reg_err=annonce_length'); die();}
    }else {header('Location:annonce_depot.php?reg_err=desc_length'); die();}
    
?>
