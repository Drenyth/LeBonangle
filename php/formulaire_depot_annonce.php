<?php
    if(!empty($_COOKIE['userid']))
    {
        $userid = $_COOKIE['userid'];
        require_once "config.php";
    
        $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
        $req->execute(array($userid));
        $data = $req->fetch();
    }
    else
    {
        $userid = false;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dépot d'annonce</title>
    <!--<link rel="stylesheet" href=".././css/style-depot_annonce.css">-->
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Roboto&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-md navbar-custom header-padding">
    <div class="container justify-content-center">
    <a href="./landing.php" class="navbar-brand">
        <img class="d-inline-block center" src="../images/logo.png" width="80">
    </a>
        <button class="navbar-toggler me-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#btn">
            <i class="bx bx-menu bx-md"></i>
        </button>
    <div class="collapse navbar-collapse flex-grow-1" id="btn">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <h1><?php echo $data['prenom'] . " " . $data['nom']; ?></h1>
                <a href="deconnexion.php" class="btn btn-danger btn-lg">Déconnexion</a>
            </li>
        </ul>
    </div>
    </div>
</nav>
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
                        <strong>Succès</strong> Bravo pour votre annonce !
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

                case 'annonce_length':
                ?>
                    <div class="alert alert-danger">
                        <strong>Erreur</strong> Intitulé d'annonce trop long
                    </div>
                <?php
                case 'desc_length':
                ?>
                    <div class="alert alert-danger">
                    <strong>Erreur</strong> description trop longue
                    </div>
                <?php  
            }
        }
    ?>
</div>
<div class="container">
<form action="annonce_traitement.php" method="post">
    <div class="mb-3">
    <label for="announcement" class="col-sm-2 col-form-label">Intitulé de l'annonce</label>
        <div class="col-sm-10">
        <input type="text" name="announcement" class="form-control" placeholder="Annonce" required>
        </div>
    </div>
    <div class="mb-3">
    <label for="image" class="col-sm-2 col-form-label">Choisir une photo</label>
        <div class="col-sm-10">
        <input type="file" name="image" class="form-control" accept="image/png, image/jpeg" required>
        </div>
    </div>
    <div class="mb-3">
    <label for="tags" class="col-sm-2 col-form-label">Tags pour l'annonce :</label>
        <div class="col-sm-10">
            <label class="form-check-label mr-4" for="inlineCheckbox1">Sport</label>
            <input class="form-check-input" type="checkbox" name="tags[]" value="Automobile">
            <label class="form-check-label mr-4" for="inlineCheckbox1">Voiture</label>
            <input class="form-check-input" type="checkbox" name="tags[]" value="Automobile">
        </div>
    </div>
    <div class="mb-3">
    <label for="description" class="col-sm-2 col-form-label">Description de l'annonce</label>
        <div class="col-sm-10">
        <textarea name="description" class="form-control" cols="30" rows="10" placeholder="Description" required></textarea>
        </div>
    </div>
    <div class="mb-3">
    <label for="price" class="col-sm-2 col-form-label">Prix</label>
        <div class="col-sm-10">
            <input type="texte" name="price" class="form-control" placeholder="Prix" required>
        </div>
    </div>
    <div class="mb-3">
    <label for="mail" class="col-sm-2 col-form-label">Adresse mail</label>
        <div class="col-sm-10">
        <input type="email" name="mail" class="form-control" placeholder="Adresse mail" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="adress" class="col-sm-2 col-form-label">Adresse</label>
        <div class="col-sm-10">
            <input type="text" name="adress" class="form-control" placeholder="Adresse" required>
        </div>
    </div>
    <div class="mb-3">
    <label for="phone" id = "bold" class="col-sm-2 col-form-label">Téléphone portable</label>
        <div class="col-sm-10">
        <input type="text" name="phone" title = "Numéro à 10 chiffres sans espace et commençant par 06 ou 07" class="form-control" placeholder = "Numéro" pattern="(06)[0-9]{8}|(07)[0-9]{8}" required>
        </div>
    </div>
    <div class="mb-3" class="col-sm-2 col-form-label"> 
        <input type="submit" role="button" aria-disabled="false" class="btn">
        <input type="Reset" name="reset" value="Réinitialiser" class="btn">
    </div>
</div>
<style>
    body{
        background-color: #333333;
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

    .navbar-custom{
        background-color: #006B6B;
    }

    .header-padding{
        margin-bottom:50px;
        /*padding-left:385px;*/
    }

    .navbar-padding{
        padding-left:735px;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>