<?php

    if(!empty($_COOKIE['userid']))
    {
        $userid = $_COOKIE['userid'];
        require_once "config.php";

        $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
        $req->execute(array($userid));
        $data = $req->fetch();

        $nom = $data['nom'];
        $prenom = $data['prenom'];
        $email = $data['email'];
        $pays = $data['pays'];
        $date_de_naissance = $data['date_de_naissance'];
        $code_postal = $data['code_postal'];
        $adresse = $data['adresse'];
        $genre = $data['genre'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification</title>
    <link rel="stylesheet" href="../css/style-inscription.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Roboto&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <header>
        <div class="inner_header">
            <div class="logo_container">
                <a href="../index.html"><img id="image" src="../images/logo_temporaire" alt="LOGO"></a>
            </div>
            <ul class="navigation">
                <h1><?php echo $data['prenom'] . " " . $data['nom']; ?></h1>
                <a href="deconnexion.php" class="btn btn-danger btn-lg">Déconnexion</a>
            </ul>
        </div>
    </header>
    <div class="login-form">
            <?php 
                if(isset($_GET['reg_err']))
                {
                    $err = htmlspecialchars($_GET['reg_err']);

                    switch($err)
                    {
                        case 'success':
                        ?>
                            <div class="alert alert-success">
                                <strong>Succès</strong> modifications effectuées !
                            </div>
                        <?php
                        break;

                        case 'password':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> mot de passe différent
                            </div>
                        <?php
                        break;

                        case 'email':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> email non valide
                            </div>
                        <?php
                        break;

                        case 'email_length':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> email trop long
                            </div>
                        <?php 
                        break;

                        case 'name_length':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> pseudo trop long
                            </div>
                        <?php
                        case 'first_name_length':
                        ?>
                            <div class="alert alert-danger">
                            <strong>Erreur</strong> pseudo trop long
                            </div>
                        <?php  
                        case 'already':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> compte deja existant
                            </div>
                        <?php 

                    }
                }
            ?>
    <div class="form">
        <form action="modification_traitement.php" method="post">
            <div class="form-group">
                <label for="first_name">Nom</label>
                <input type="text" name="name" class="form-control" placeholder="Nom" value="<?php echo $nom; ?>" required>
            </div>
            <div class="form-group">
                <label for="name">Prénom</label>
                <input type="text" name="first_name" class="form-control" placeholder="Prénom" value="<?php echo $prenom; ?>" required>
            </div>              
            <div class="form-group">
                <label for="gender">Genre</label>
                <input type="radio" name="gender" value="Homme" required>Homme
                <input type="radio" name="gender" value="Femme" required>Femme
            </div>
            <div class="form-group">
                <label for="birth">Date de naissance</label>
                <input type="date" name="birth" id="form_birth" value="<?php echo $date_de_naissance; ?>" required>
            </div>
            <div class="form-group">
                <label for="country">Pays</label>
                <input type="text" name="country" class="form-control" placeholder="Pays" value="<?php echo $pays; ?>" required>
            </div>
            <div class="form-group">
                <label for="postal">Code postal</label>
                <input type="text" name="postal" class="form-control" placeholder="95570" value="<?php echo $code_postal; ?>" required>
            </div>
            <div class="form-group">
                <label for="adress">Adresse</label>
                <input type="text" name="adress" class="form-control" placeholder="Adresse" value="<?php echo $adresse; ?>" required>
            </div>
            <div class="form-group">
                <label for="mail">Adresse mail</label>
                <input type="email" name="mail" class="form-control" placeholder="Adresse mail" value="<?php echo $email; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password_retype" class="form-control" placeholder="Re-tapez le mot de passe" required autocomplete="off">
            </div>
            <div class="form-group d-none">
                <label for="favoris">Favoris</label>
                <input type="text" name="favoris" class="form-control" placeholder="Favoris">
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="interets[]" value="Immobilier">
                <label class="form-check-label" for="inlineCheckbox1">Immobilier</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="interets[]" value="Automobile">
                <label class="form-check-label" for="inlineCheckbox1">Automobile</label>
            </div>
            <div class="form-group">
            <button type="submit" name="submit" role="button" aria-disabled="false" class="btn">Envoyer</button>
            <input type="Reset" name="reset" value="Réinitialiser" class="btn">
            </div>
        </form>
    </div>

    <script src="./js/formulaire_inscription.js"></script>
    <style>
        body{
        background-color: #333333;
        min-width: 1400px;
        color: white;
        font-family: 'Roboto', sans-serif;
        }
        .login-form {
            width: 70%;
            height: 100%;
            margin-left: 15%;
        }
        .login-form form {
            margin-bottom: 15px;
            background: #333333;
            padding: 30px;
        }
        .form-control, .btn {
            min-height: 38px;
            border-radius: 2px;
        }
        .btn {        
            font-size: 15px;
            font-weight: bold;
            background: #006B6B;
        }
        </style>
</body>
</html>