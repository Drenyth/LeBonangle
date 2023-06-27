<!-- Traitement du formulaire de la connexion-->
<?php
    //Execution du fichier se connectant a la base de donnée
    require_once 'config.php';

    if(!empty($_POST['mail']) && !empty($_POST['password']))
    {

        $mail = htmlspecialchars($_POST['mail']);
        $password = htmlspecialchars($_POST['password']);

        //requete recuperant les données de l'utilisateur
        $check = $bdd->prepare('SELECT id, nom, prenom, email, password, token FROM utilisateurs WHERE email = ?');
        $check->execute(array($mail));
        $data = $check->fetch();
        $row = $check->rowCount();

        //Verifications que les donnees soient en accord avec la base de donnée et valides
        if($row > 0)
        {
            if(filter_var($mail, FILTER_VALIDATE_EMAIL))
            {
                if(password_verify($password, $data['password']))
                {   
                    //creation du cookie contenant l'id de l'utilisateur
                    if(empty($_COOKIE['userid']))
                    {
                        $id = $data['id'];
                        setcookie('userid', $id, time() + 60 * 60);
                    }
                    //si il existait deja un cookie pour quelconque raison on le supprime et en crée un nouveau
                    else
                    {   
                        unset($_COOKIE['userid']);
                        setcookie('userid', '', time() - 10);
                        $id = $data['id'];
                        setcookie('userid', $id, time() + 60 * 60);
                    }
                    $_SESSION['user'] = $data['token'];
                    header('Location:landing.php');
                    die();
                } else{ header('Location:connexion.php?login_err=password'); die(); }
            } else{ header('Location:connexion.php?login_err=email'); die(); }
        } else{ header('Location:connexion.php?login_err=already'); die(); }
    }else{ header('Location:connexion.php'); die();}
?>