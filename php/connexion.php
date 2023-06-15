<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <!--<link rel="stylesheet" href="./../css/style-connexion.css">-->
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Roboto&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<!--<header>
        <div class="inner_header">
            <div class="logo_container">
                <a href="../index.html"><img id="image" src="./../images/logo.png" alt="LOGO"></a>
            </div>
        </div>
</header>-->
<div class="login-form">
             <?php 
                if(isset($_GET['login_err']))
                {
                    $err = htmlspecialchars($_GET['login_err']);

                    switch($err)
                    {
                        case 'password':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> mot de passe incorrect
                            </div>
                        <?php
                        break;

                        case 'email':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> email incorrect
                            </div>
                        <?php
                        break;

                        case 'already':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> compte non existant
                            </div>
                        <?php
                        break;
                    }
                }
                ?> 
</div>
    <div class="container">
        <form action="connexion_traitement.php" method="post">
            <div class="mb-3">
                <label class="col-sm-2 col-form-label"for="mail">Adresse mail</label>
                <div class="col-sm-10">
                    <input type="email" name="mail" class="form-control" placeholder="Adresse mail" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="col-sm-2 col-form-label"for="password">Mot de passe</label>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
                </div>
            </div>
            <div class="mb-3">
                <div class="col-sm-10">
                    <button type="submit" name="submit" role="button" aria-disabled="false" class="btn">Envoyer</button></p> 
                </div>
            </div>
        </form>
    </div>
    <div class="inscription">
        <a href="./inscription.php"><button class="btn">S'inscrire</button></a>
    </div>
    <script src="./../js/formulaire_connexion.js"></script>
    <style>
        body{
        background-color: #333333;
        color: white;
        font-family: 'Roboto', sans-serif;
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