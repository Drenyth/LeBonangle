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

    //var_dump(id_utilisateur);
    $annonce = htmlspecialchars($_POST['announcement']);
    //var_dump($annonce);
    $image = htmlspecialchars($_POST['image']);
    //var_dump($image);
    $desc = htmlspecialchars($_POST['description']);
    //var_dump($desc);
    $price = htmlspecialchars($_POST['price']);
    //var_dump($prix);
    $address = htmlspecialchars($_POST['adress']);
    //var_dump($address);
    $email = htmlspecialchars($_POST['mail']);
    //$phonenum = htmlspecialchars($_POST['phone']);
    //var_dump($phonenum);



    if(strlen($desc) <= 400){
        if(strlen($annonce) <= 100){
            if(strlen($mail) <= 100){
                if(filter_var($mail, FILTER_VALIDATE_EMAIL)){

                $insert = $bdd->prepare('INSERT INTO annonce(nom_annonce, photo, description, prix, email, adresse_postal) 
                    VALUES(:nom_annonce, :photo, :description, :prix, :email, :adresse_postal)');
                $insert->execute(array(
                    'nom_annonce' => $annonce,
                    'photo' => $image,
                    'description' => $desc,
                    'prix' => $price,
                    'email' => $email,
                    'adresse_postal' => $address
                ));
                header('Location:formulaire_depot_annonce.php?reg_err=success');
                die();

                    }else {header('Location:inscription.php?reg_err=email'); die();}
            }else {header('Location:inscription.php?reg_err=email_length'); die();}
        }else {header('Location:formulaire_depot_annonce.php?reg_err=annonce_length'); die();}
    }else {header('Location:formulaire_depot_annonce.php?reg_err=desc_length'); die();}
    
?>
