<?php
    //recuperation des données utilisateur avec les cookies si l'utilisateur est connecté
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
        <img class="d-inline-block center" src="../images/logo.png" width="100">
    </a>
        <button class="navbar-toggler me-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#btn">
            <i class="bx bx-menu bx-md"></i>
        </button>
    <div class="collapse navbar-collapse flex-grow-1" id="btn">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <h2><?php echo $data['prenom'] . " " . $data['nom']; ?></h2>
                <a href="Pour_vous.php" class="btn btn-dark btn-md">Pour vous</a>
                <a href="Favoris.php" class="btn btn-dark btn-md">Favoris</a>
                <a href="mes_annonces.php" class="btn btn-dark btn-md">Mes annonces</a>
                <a href="modification.php" class="btn btn-dark btn-md">Mon compte</a>
                <a href="deconnexion.php" class="btn btn-dark btn-md">Déconnexion</a>
            </li>
        </ul>
    </div>
    </div>
</nav>
<!--Gestion des erreurs liées au depot d'annonce-->
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
                case 'price':
                ?>
                    <div class="alert alert-danger">
                    <strong>Erreur</strong> mauvais prix
                    </div>
                <?php 
            }
        }
    ?>
</div>

<div class="container">
<form action="annonce_ajout.php" method="post" enctype="multipart/form-data" >
    <div class="mb-3">
        <label for="announcement" class="col-sm-2 col-form-label">Intitulé de l'annonce</label>
        <div class="col-sm-10">
            <input type="text" name="announcement" class="form-control" placeholder="Annonce" required>
        </div>
    </div>

    <div class="mb-3">
    <label for="typeannonce" class="col-sm-2 col-form-label">Type d'annonce</label>
        <div class="col-sm-10">
            <input type="radio" name="typeannonce" value="service" checked>
            <label for="service">Service</label>
            <input type="radio" name="typeannonce" value="bien">
            <label for="bien">Bien</label>
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
        <select name="tags" class="selectpicker">
            <option value="Immobilier">Immobilier</option>
            <option value="Automobile">Automobile</option>
            <option value="Lecture">Lecture</option>
            <option value="Mode">Mode</option>
            <option value="Bricolage">Bricolage</option>
            <option value="Jeux">Jeux</option>
            <option value="Sport">Sport</option>
            <option value="Musique">Musique</option>
        </select>
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

    <div id="divTypeBien" class="mb-3">
        <label for="typebien" id="bold" class="col-sm-2 col-form-label">Type de Bien</label>
        <div class="col-sm-10">
            <select name="typebien" class="selectpicker">
                    <option value="0">Location</option>
                    <option value="1">Vente</option>
            </select>
        </div>
    </div>

    <div id="divEtat" class="mb-3">
        <label for="etat" id="bold" class="col-sm-2 col-form-label">Etat</label>
        <div class="col-sm-10">
            <select name="etat" class="selectpicker">
                <option value="bon">Bon</option>
                <option value="moyen">Moyen</option>
                <option value="mauvais">Mauvais</option>
            </select>
        </div>
    </div>

    <div id="divDateDebut" class="mb-3">
        <label for="date" id="bold" class="col-sm-2 col-form-label">Date de début</label>
        <div class="col-sm-10">
            <input type="date" name="date" title="" class="form-control" placeholder="date">
        </div>
    </div>

    <div id="divDateFin" class="mb-3">
        <label for="date" id="bold" class="col-sm-2 col-form-label">Date de fin</label>
        <div class="col-sm-10">
            <input type="date" name="date_fin" title="" class="form-control" placeholder="date">
        </div>
    </div>

    </div>
        <div class="mb-3" class="col-sm-2 col-form-label"> 
            <input type="submit" role="button" aria-disabled="false" class="btn">
            <input type="Reset" name="reset" value="Réinitialiser" class="btn">
        </div>
    </div>
</form>
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

<script>
// Récupérer l'élément de sélection pour le type d'annonce
var typeAnnonceSelect = document.querySelector('input[name="typeannonce"]:checked');

// Définir les divs à afficher ou masquer en fonction de la valeur initiale de typeAnnonceSelect
toggleDivs(typeAnnonceSelect.value);

// Écouter les changements de valeur dans le type d'annonce
var typeAnnonceInputs = document.querySelectorAll('input[name="typeannonce"]');
typeAnnonceInputs.forEach(function(input) {
    input.addEventListener('change', function() {
        toggleDivs(this.value);
    });
});

// Fonction pour afficher ou masquer les divs en fonction de la valeur de type d'annonce
function toggleDivs(typeAnnonceValue) {
    var divTypeBien = document.getElementById('divTypeBien');
    var divEtat = document.getElementById('divEtat');
    var divDateDebut = document.getElementById('divDateDebut');
    var divDateFin = document.getElementById('divDateFin');

    if (typeAnnonceValue === 'bien') {
        divTypeBien.style.display = 'block';
        divEtat.style.display = 'block';
        divDateDebut.style.display = 'none';
        divDateFin.style.display = 'none';
    } else if (typeAnnonceValue === 'service') {
        divTypeBien.style.display = 'none';
        divEtat.style.display = 'none';
        divDateDebut.style.display = 'block';
        divDateFin.style.display = 'block';
    }
}
</script>

<!--Script bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>