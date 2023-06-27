<!-- Page de modification de compte-->
<?php

    //récupération user id et données correspondantes permettant de pré remplir le formulaire
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
        $interets = $data['interets'];
        $interets = substr($interets, 0, -1);
        $tableau_interets = explode(",",$interets);
        $immobilier = 0;
        $automobile = 0;
        $lecture = 0;
        $mode = 0;
        $bricolage = 0;
        $jeux = 0;
        $sport = 0;
        $musique = 0;

        foreach ($tableau_interets as $val)
        {
            switch($val)
            {
                case 'Immobilier':
                    
                    $immobilier = $val;
                    break;
                case 'Automobile':
                    $automobile = $val;
                    break;
                case 'Lecture':
                    $lecture = $val;
                    break;
                case 'Mode':
                    $mode = $val;
                    break;
                case 'Bricolage':
                    $bricolage = $val;
                    break;
                case 'Jeux':
                    $jeux = $val;
                    break;
                case 'Sport':
                    $sport = $val;
                    break;
                case 'Musique':
                    $musique = $val;
                    break;
            }
        }
            
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
    <title>Modification</title>
    <!--<link rel="stylesheet" href="../css/style-inscription.css">-->
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
        <img class="d-inline-block center" src="../images/logo.png" width="100">
    </a>
        <button class="navbar-toggler me-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#btn">
            <i class="bx bx-menu bx-md"></i>
        </button>
    <div class="collapse navbar-collapse flex-grow-1" id="btn">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <h2><?php echo $data['prenom'] . " " . $data['nom']; ?></h2>
                <a href="#" class="btn btn-dark btn-md">Messages</a>
                <a href="Pour_vous.php" class="btn btn-dark btn-md">Pour vous</a>
                <a href="Favoris.php" class="btn btn-dark btn-md">Favoris</a>
                <a href="mes_annonces.php" class="btn btn-dark btn-md">Mes annonces</a>
                <a href="deconnexion.php" class="btn btn-dark btn-md">Déconnexion</a>
            </li>
        </ul>
    </div>
    </div>
</nav>
<!--Gestion des erreurs lié a la modification d'annonces -->
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
                        <strong>Erreur</strong> nom trop long
                    </div>
                <?php
                break;
                case 'first_name_length':
                ?>
                    <div class="alert alert-danger">
                    <strong>Erreur</strong> prénom trop long
                    </div>
                <?php  

            }
        }
    ?>
</div>

<!--Formulaire de modification d'annonce-->
<div class="container">
<form action="modification_compte_traitement.php" method="post">
    <div class="mb-3">
        <label for="first_name" class="col-sm-2 col-form-label">Nom</label>
        <div class="col-sm-10">
            <input type="text" name="name" class="form-control" placeholder="Nom" value="<?php echo $nom; ?>" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="name" class="col-sm-2 col-form-label">Prénom</label>
        <div class="col-sm-10">
        <input type="text" name="first_name" class="form-control" placeholder="Prénom" value="<?php echo $prenom; ?>" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="gender" class="col-sm-2 col-form-label">Genre</label>
        <div class="col-sm-10">

        <?php if($genre == "Homme"): ?>
            <input type="radio" name="gender" value="Homme" checked="checked" required>Homme
        <?php else: ?>
            <input type="radio" name="gender" value="Homme" required>Homme
        <?php endif; ?>

        <?php if($genre == "Femme"): ?>
            <input type="radio" name="gender" value="Femme" checked="checked" required>Femme
        <?php else: ?>
            <input type="radio" name="gender" value="Femme" required>Femme
        <?php endif; ?>
        </div>
    </div>
    <div class="mb-3">
        <label for="birth" class="col-sm-2 col-form-label">Date de naissance</label>
        <div class="col-sm-10">
            <input type="date" name="birth" id="form_birth" value="<?php echo $date_de_naissance; ?>" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="country" class="col-sm-2 col-form-label">Pays</label>
        <div class="col-sm-10">
            <input type="text" name="country" class="form-control" placeholder="Pays" value="<?php echo $pays; ?>" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="postal" class="col-sm-2 col-form-label">Code postal</label>
        <div class="col-sm-10">
            <input type="text" name="postal" class="form-control" placeholder="95570" value="<?php echo $code_postal; ?>" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="adress" class="col-sm-2 col-form-label">Adresse</label>
        <div class="col-sm-10">
            <input type="text" name="adress" class="form-control" placeholder="Adresse" value="<?php echo $adresse; ?>" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="mail" class="col-sm-2 col-form-label">Adresse mail</label>
        <div class="col-sm-10">
            <input type="email" name="mail" class="form-control" placeholder="Adresse mail" value="<?php echo $email; ?>" required>
        </div>
    </div>
            
    <a href="mot_de_passe.php" class="btn btn-dark btn-lg left-custom">Modifier votre mot de passe</a>
    <div class="mb-3 d-none">
        <label for="favoris" class="col-sm-2 col-form-label">Favoris</label>
        <div class="col-sm-10">
            <input type="text" name="favoris" class="form-control" placeholder="Favoris">
        </div>
    </div>
    <div class="mb-3">
        <label for="inlineCheckbox1" class="col-sm-2 col-form-label">Centres d'intérêts</label>
        <div class="col-sm-10">

         <?php if($immobilier == 'Immobilier'): ?>
            <input class="form-check-input ml-1" type="checkbox" name="interets[]" value="Immobilier" checked>
            <label class="form-check-label pl-4 mr-4" for="inlineCheckbox1">Immobilier</label>
        <?php else: ?>
            <input class="form-check-input ml-1" type="checkbox" name="interets[]" value="Immobilier">
            <label class="form-check-label pl-4 mr-4" for="inlineCheckbox1">Immobilier</label>
        <?php endif; ?>
        <?php if($automobile == 'Automobile'): ?>
            <input class="form-check-input" type="checkbox" name="interets[]" value="Automobile" checked>
            <label class="form-check-label mr-4" for="inlineCheckbox1">Automobile</label>
        <?php else: ?>
            <input class="form-check-input" type="checkbox" name="interets[]" value="Automobile">
            <label class="form-check-label mr-4" for="inlineCheckbox1">Automobile</label>
        <?php endif; ?>
        <?php if($lecture == 'Lecture'): ?>
            <input class="form-check-input" type="checkbox" name="interets[]" value="Lecture" checked>
            <label class="form-check-label mr-4" for="inlineCheckbox1">Lecture</label>
        <?php else: ?>
            <input class="form-check-input" type="checkbox" name="interets[]" value="Lecture">
            <label class="form-check-label mr-4" for="inlineCheckbox1">Lecture</label>
        <?php endif; ?>
        <?php if($mode == 'Mode'): ?>
            <input class="form-check-input" type="checkbox" name="interets[]" value="Mode" checked>
            <label class="form-check-label mr-4" for="inlineCheckbox1">Mode</label>
        <?php else: ?>
            <input class="form-check-input" type="checkbox" name="interets[]" value="Mode">
            <label class="form-check-label mr-4" for="inlineCheckbox1">Mode</label>
        <?php endif; ?>
        <?php if($bricolage == 'Bricolage'): ?>
            <input class="form-check-input" type="checkbox" name="interets[]" value="Bricolage" checked>
            <label class="form-check-label mr-4" for="inlineCheckbox1">Bricolage</label>
        <?php else: ?>
            <input class="form-check-input" type="checkbox" name="interets[]" value="Bricolage">
            <label class="form-check-label mr-4" for="inlineCheckbox1">Bricolage</label>
        <?php endif; ?>
        <?php if($jeux == 'Jeux'): ?>
            <input class="form-check-input" type="checkbox" name="interets[]" value="Jeux" checked>
            <label class="form-check-label mr-4" for="inlineCheckbox1">Jeux</label>
        <?php else: ?>
            <input class="form-check-input" type="checkbox" name="interets[]" value="Jeux">
            <label class="form-check-label mr-4" for="inlineCheckbox1">Jeux</label>
        <?php endif; ?>
        <?php if($sport == 'Sport'): ?>
            <input class="form-check-input" type="checkbox" name="interets[]" value="Sport" checked>
            <label class="form-check-label mr-4" for="inlineCheckbox1">Sport</label>
        <?php else: ?>
            <input class="form-check-input" type="checkbox" name="interets[]" value="Sport">
            <label class="form-check-label mr-4" for="inlineCheckbox1">Sport</label>
        <?php endif; ?>
        <?php if($musique == 'Musique'): ?>
            <input class="form-check-input" type="checkbox" name="interets[]" value="Musique" checked>
            <label class="form-check-label mr-4" for="inlineCheckbox1">Musique</label>
        <?php else: ?>
            <input class="form-check-input" type="checkbox" name="interets[]" value="Musique">
            <label class="form-check-label mr-4" for="inlineCheckbox1">Musique</label>
        <?php endif; ?>
        </div>
    </div>
    <div class="mb-3"> 
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
    }
    
    .navbar-padding{
        padding-left:735px;
    }

    .left-custom{
        margin-left:11px;
    }
</style>
<!--Script bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>