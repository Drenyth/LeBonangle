<!-- Traitement du formulaire de modification des informations du compte-->
<?php
    //même fonctionnement que annonce_ajout.php
    require_once 'config.php';

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

    if(!empty($_POST['first_name']) && !empty($_POST['name']) && !empty($_POST['gender']) && !empty($_POST['birth']) && !empty($_POST['country']) && !empty($_POST['postal']) && !empty($_POST['adress']) && !empty($_POST['mail']))
    {
        $first_name = htmlspecialchars($_POST['first_name']);
        $name = htmlspecialchars($_POST['name']);
        $gender = htmlspecialchars($_POST['gender']);
        $birth = htmlspecialchars($_POST['birth']);
        $country = htmlspecialchars($_POST['country']);
        $postal = htmlspecialchars($_POST['postal']);
        $adresse = htmlspecialchars($_POST['adress']);
        $mail = htmlspecialchars($_POST['mail']);
        $interets = $_POST['interets'];

        
        $email = strtolower($mail);
        
        
        if(strlen($first_name) <= 20){
            if(strlen($name) <= 20){
                if(strlen($mail) <= 100){
                    if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
                        
                        $check = $bdd->prepare('SELECT prenom, nom, password FROM utilisateurs WHERE id = ?');
                        $check->execute(array($userid));
                        $data = $check->fetch();
                        $row = $check->rowCount();

                        //requete supprimant les données de l'utilisateur
                        $check = $bdd->prepare('DELETE FROM utilisateurs WHERE id = ?');
                        $check->execute(array($userid));
                        
                        $chk="";  
                        foreach($interets as $chk1)  
                        {  
                            $chk .= $chk1.",";  
                        }
    
                        $insert = $bdd->prepare('INSERT INTO utilisateurs(id, email, password, ip, prenom, nom, genre, date_de_naissance, pays, adresse, code_postal, favoris, interets, token, date_inscription) VALUES(:id, :email, :password, :ip, :prenom, :nom, :genre, :date_de_naissance, :pays, :adresse, :code_postal, :favoris, :interets, :token, :date_inscription)');
                        $insert->execute(array(
                        'id' => $userid,
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
                        'token' => $token,
                        'date_inscription' => $date_creation
                        ));
                        unset($_COOKIE['userid']);
                        setcookie('userid', '', time() - 10);
                        header('Location:connexion.php?reg_err=success');
                        die();
                    }else {header('Location:modification.php?reg_err=email'); die();}
                }else {header('Location:modification.php?reg_err=email_length'); die();}
            }else {header('Location:modification.php?reg_err=name_length'); die();}
        }else {header('Location:modification.php?reg_err=first_name_length'); die();}
    }