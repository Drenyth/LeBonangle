<?php
    require_once 'config.php';

    if(!empty($_POST['first_name']) && !empty($_POST['name']) && !empty($_POST['gender']) && !empty($_POST['birth']) && !empty($_POST['country']) && !empty($_POST['postal']) && !empty($_POST['adress']) && !empty($_POST['mail']) && !empty($_POST['password']) && !empty($_POST['password_retype']))
    {
        $first_name = htmlspecialchars($_POST['first_name']);
        $name = htmlspecialchars($_POST['name']);
        $gender = htmlspecialchars($_POST['gender']);
        $birth = htmlspecialchars($_POST['birth']);
        $country = htmlspecialchars($_POST['country']);
        $postal = htmlspecialchars($_POST['postal']);
        $adresse = htmlspecialchars($_POST['adress']);
        $mail = htmlspecialchars($_POST['mail']);
        $password = htmlspecialchars($_POST['password']);
        $password_retype = htmlspecialchars($_POST['password_retype']);
        $interets = $_POST['interets'];

        //requete recuperant les informations de l'utilisateur
        $check = $bdd->prepare('SELECT prenom, nom, password FROM utilisateurs WHERE email = ?');
        $check->execute(array($mail));
        $data = $check->fetch();
        $row = $check->rowCount();

        $email = strtolower($mail);
        
        //Verifications que les donnees soient en accord avec la base de donnée et valides
        if($row == 0){
            if($password == $password_retype){
                if(strlen($first_name) <= 20){
                    if(strlen($name) <= 20){
                        if(strlen($mail) <= 100){
                            if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
                                
                                //encodage du mot de passe avec la technologie BCRYPT
                                $cost = ['cost' => 12];
                                $password = password_hash($password, PASSWORD_BCRYPT, $cost);

                                
                                $ip = $_SERVER['REMOTE_ADDR'];
                                
                                //Concatenation des centres d'interets
                                $chk="";  
                                foreach($interets as $chk1)  
                                {  
                                    $chk .= $chk1.",";  
                                }
                                
                                //insertion des informations dans la table utilisateurs
                                $insert = $bdd->prepare('INSERT INTO utilisateurs(email, password, ip, prenom, nom, genre, date_de_naissance, pays, adresse, code_postal, favoris, interets, token) VALUES(:email, :password, :ip, :prenom, :nom, :genre, :date_de_naissance, :pays, :adresse, :code_postal, :favoris, :interets, :token)');
                                $insert->execute(array(
                                    'email' => $mail,
                                    'password' => $password,
                                    'ip' => $ip,
                                    'prenom' => $first_name,
                                    'nom' => $name,
                                    'genre' => $gender,
                                    'date_de_naissance' => $birth,
                                    'pays' => $country,
                                    'adresse' => $adresse,
                                    'code_postal' => $postal,
                                    'favoris' => "",
                                    'interets' => $chk,
                                    'token' => bin2hex(openssl_random_pseudo_bytes(64))
                                ));
    
                                header('Location:connexion.php?reg_err=success');
                                die();
                            }else {header('Location:inscription.php?reg_err=email'); die();}
                        }else {header('Location:inscription.php?reg_err=email_length'); die();}
                    }else {header('Location:inscription.php?reg_err=name_length'); die();}
                }else {header('Location:inscription.php?reg_err=first_name_length'); die();}
            }else {header('Location:inscription.php?reg_err=password'); die();}
        }else {header('Location:inscription.php?reg_err=already'); die();}
    }