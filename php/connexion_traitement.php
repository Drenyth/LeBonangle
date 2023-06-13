<?php
    session_start();
    require_once 'config.php';

    if(!empty($_POST['mail']) && !empty($_POST['password']))
    {

        $mail = htmlspecialchars($_POST['mail']);
        $password = htmlspecialchars($_POST['password']);

        $check = $bdd->prepare('SELECT nom, prenom, email, password, token FROM utilisateurs WHERE email = ?');
        $check->execute(array($mail));
        $data = $check->fetch();
        $row = $check->rowCount();

        if($row > 0)
        {
            if(filter_var($mail, FILTER_VALIDATE_EMAIL))
            {
                if(password_verify($password, $data['password']))
                {
                    $_SESSION['user'] = $data['token'];
                    header('Location:landing.php');
                    die();
                } else{ header('Location:connexion.php?login_err=password'); die(); }
            } else{ header('Location:connexion.php?login_err=email'); die(); }
        } else{ header('Location:connexion.php?login_err=already'); die(); }
    }else{ header('Location:connexion.php'); die();}