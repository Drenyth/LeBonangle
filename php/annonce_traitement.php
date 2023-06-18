<?php
    require_once 'config.php';
    if(!empty($_COOKIE['userid']))
    {
        $userid = $_COOKIE['userid'];
        require_once "config.php";
    
        $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
        $req->execute(array($userid));
        $data = $req->fetch();
    }

    
    $annonce = htmlspecialchars($_POST['announcement']);
    $image = htmlspecialchars($_POST['image']);
    $desc = htmlspecialchars($_POST['description']);
    $price = htmlspecialchars($_POST['price']);
    $address = htmlspecialchars($_POST['adress']);
    $email = htmlspecialchars($_POST['mail']);
    $tags = htmlspecialchars($_POST['tags']);
    $typeannonce = htmlspecialchars($_POST['typeannonce']);
    $typebien = htmlspecialchars($_POST['typebien']);
    $etat = htmlspecialchars($_POST['etat']);
    $date = htmlspecialchars($_POST['date']);

    //var_dump($annonce);                            
    //var_dump($image);
    //var_dump($prix);
    //var_dump($desc);
    //var_dump($address);
    //var_dump($email);
    //var_dump($tags);
    //echo $typeannonce;
    //var_dump($typebien);
    //var_dump($etat);
    //var_dump($date);

    if(strlen($desc) <= 1000){
        if(strlen($annonce) <= 100){
            if(strlen($email) <= 100){
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    if(is_numeric($price)){

                        $insert = $bdd->prepare('INSERT INTO annonce(nom_annonce, id_utilisateur, photo, description, prix, email, adresse_postal, tags) 
                            VALUES(:nom_annonce, :id_utilisateur, :photo, :description, :prix, :email, :adresse_postal, :tags)');
                        $insert->execute(array(
                            'nom_annonce' => $annonce,
                            'id_utilisateur' => $userid,
                            'photo' => $image,
                            'description' => $desc,
                            'prix' => $price,
                            'email' => $email,
                            'adresse_postal' => $address,
                            'tags'=> $tags
                        ));
                        $id_annonce = $bdd->lastInsertId(); 

                        if($typeannonce == "bien"){
                            $insert2 = $bdd->prepare('INSERT INTO bien(etat, id_annonce, type)
                                VALUES(:etat, :id_annonce, :type)');
                            $insert2->execute(array(
                                'id_annonce' => $id_annonce,
                                'etat'=>$etat,
                                'type'=>intval($typebien),
                            ));
                        }else{
                            $insert2 = $bdd->prepare('INSERT INTO service(date, id_annonce)
                                VALUES(:date, :id_annonce)');
                            $insert2->execute(array(
                                'date'=>$date,
                                'id_annonce' => $id_annonce,
                            ));
                        }

                        header('Location:formulaire_depot_annonce.php?reg_err=success');
                        die();

                    }else{header('Location:formulaire_depot_annonce.php?reg_err=price');}
                }else {header('Location:inscription.php?reg_err=email'); die();}
            }else {header('Location:inscription.php?reg_err=email_length'); die();}
        }else {header('Location:formulaire_depot_annonce.php?reg_err=annonce_length'); die();}
    }else {header('Location:formulaire_depot_annonce.php?reg_err=desc_length'); die();}
    
?>
