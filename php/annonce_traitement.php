<?php
    require_once 'config2.php';
    if(!empty($_COOKIE['userid']))
    {
        $userid = $_COOKIE['userid'];
        require_once "config.php";
    
        $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
        $req->execute(array($userid));
        $data = $req->fetch();
    }
    $id_annonce = 0201; 
    //var_dump($id_annonce);
    $id_utilisateur = 0101;
    //var_dump();
    $annonce = htmlspecialchars($_POST['announcement']);
    //var_dump($annonce);
    $image = htmlspecialchars($_POST['image']);
    //var_dump($image);
    $desc = htmlspecialchars($_POST['description']);
    //var_dump($desc);
    $price = htmlspecialchars($_POST['price']);
    //var_dump($prix);
    $mail = htmlspecialchars($_POST['mail']);
    //var_dump($mail);
    $address = htmlspecialchars($_POST['adress']);
    //var_dump($address);
    $phonenum = htmlspecialchars($_POST['phone']);
    //var_dump($phonenum);


 
            if(strlen($desc) <= 400){
                if(strlen($annonce) <= 20){
                    if(strlen($mail) <= 100){
                        if(filter_var($mail, FILTER_VALIDATE_EMAIL)){

                        $insert = $bdd->prepare('INSERT INTO annonce(id_annonce, id_utilisateur, nom_annonce, photo, description, prix, adresse_mail, adresse_postal, telephone) 
                            VALUES(:id_annonce, :id_utilisateur, :nom_annonce, :photo, :description, :prix, :adresse_mail, :adresse_postal, :telephone)');
                        $insert->execute(array(
                            'id_annonce' => $id_annonce,
                            'id_utilisateur' => $id_utilisateur,
                            'nom_annonce' => $annonce,
                            'photo' => $image,
                            'description' => $desc,
                            'prix' => $price,
                            'adresse_mail' => $mail,
                            'adresse_postal' => $address,
                            'telephone' => $phonenum,
                        ));
                        header('Location:formulaire_depot_annonce.php?reg_err=success');
                        die();

                            }else {header('Location:inscription.php?reg_err=email'); die();}
                    }else {header('Location:inscription.php?reg_err=email_length'); die();}
                }else {header('Location:formulaire_depot_annonce.php?reg_err=annonce_length'); die();}
            }else {header('Location:formulaire_depot_annonce.php?reg_err=desc_length'); die();}
    
?>
