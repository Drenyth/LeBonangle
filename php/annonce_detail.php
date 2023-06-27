<!-- Page affichant les details d'une annonce-->
<!-- récupération user id et données correspondantes -->
<?php

    require_once "config.php";
    $id_annonce = $_GET['id'];

    if(!empty($_COOKIE['userid']))
    {
        $userid = $_COOKIE['userid'];

        /* requête pour avoir les données de l'utilisateur */
        $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
        $req->execute(array($userid));
        $data = $req->fetch();
    }
    else
    {
        $userid = false;
    }

    /* requête pour avoir les données de l'annonce */
    $request = $bdd->prepare('SELECT * FROM annonce WHERE id_annonce = ?');
    $request->execute(array($id_annonce));
    $madata = $request->fetch();

    $titre = $madata['nom_annonce'];
    $description = $madata['description'];
    $prix = $madata['prix'];
    $email = $madata['email'];
    $adresse_postal = $madata['adresse_postal'];
    $tags = $madata['tags'];
    $photo = $madata['photo'];
    
    /* requête pour savoir s'il s'agit d'un bien ou d'un service */
    $request2 = $bdd->prepare('SELECT * FROM bien WHERE id_annonce = ?');
    $request2->execute(array($id_annonce));
    $bien = $request2->fetch();
    $row = $request2->rowCount();

    if(($row != 0)){
            $type = $bien['type'];
            $etat = $bien['etat'];

            $type = 'Prix:';
            $date=0;
            $date_fin = 0;
    }
    else
    {
        $request2 = $bdd->prepare('SELECT * FROM service WHERE id_annonce = ?');
        $request2->execute(array($id_annonce));
        $service = $request2->fetch();

        $date = $service['date'];
        $date_fin = $service['date_fin'];
        $etat=0;
        $type='Mensualité:';
    }

    //requête pour savoir si l'utilisateur a deja mis l'annonce dans ses favoris
    if(isset($id_annonce)){
        $check_favoris = $bdd->prepare('SELECT * FROM favoris WHERE id_utilisateur = ? and id_annonce = ?');
        $check_favoris->execute(array($userid,$id_annonce));
        $row_data_favoris = $check_favoris->rowCount();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le BonAngle</title>
    <!--<link rel="stylesheet" href=".././css/style.css">-->
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Roboto&display=swap" rel="stylesheet">
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
                <!--Si l'utilisateur est connecté on affiche les boutons suivants -->
                <?php if ($userid): ?>
                <h2><?php echo $data['prenom'] . " " . $data['nom']; ?></h2>
                <a href="#" class="btn btn-dark btn-md">Messages</a>
                <a href="Pour_vous.php" class="btn btn-dark btn-md">Pour vous</a>
                <a href="Favoris.php" class="btn btn-dark btn-md">Favoris</a>
                <a href="mes_annonces.php" class="btn btn-dark btn-md">Mes annonces</a>
                <a href="modification.php" class="btn btn-dark btn-md">Mon compte</a>
                <a href="deconnexion.php" class="btn btn-dark btn-md">Déconnexion</a>
                <?php else: ?>
                <a href="inscription.php" class="btn btn-dark btn-lg">S'inscrire</a>
                <a href="connexion.php" class="btn btn-dark btn-lg">Se connecter</a>
                <?php endif; ?>
            </li>
        </ul>
    </div>
    </div>
</nav>
<!--Gestion des erreurs lié a l'ajout de l'annonce dans les favoris -->
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
                        <strong>Succès</strong> Enregistrement dans les favoris réussi !
                    </div>
                <?php
                break;

                case 'already':
                    ?>
                        <div class="alert alert-danger">
                            <strong>Erreur</strong> Cette annonce est deja dans vos favoris
                        </div>
                    <?php
                    break;

                case 'password':
                    ?>
                        <div class="alert alert-danger">
                            <strong>Erreur</strong> Veuillez reessayer
                        </div>
                    <?php
                    break;

            }
        }
    ?>
</div>

<div class="container">
    <!--Si l'utilisateur est connecté est l'annonce n'est pas dans ses favoris alors le bouton est mis -->
    <?php if($userid and ($row_data_favoris == 0)): ?>
        <?php echo '<a id="bouton_fav" href="favoris_traitement.php?id_annonce='.$id_annonce.'">'?>
        <button class="btn btn-dark btn-lg mb-4">Favoris</button>
        </a>
    <?php endif; ?>
    <!--Affichage des détails de l'annonce -->
    <div class="row gy-2 gx-3 align-items-center mb-4">
        <div class="container">
            <?php  echo '<img src="'.$photo.'" />';?>
        <div>
        <h2 class="title-custom"><?php echo $titre; ?></h2>
        <?php if(isset($etat) && $etat!= 0 ): ?>
            <p><?php echo $type . ' ' . $prix . '€' ?></p>
            <p><?php echo 'Etat :'. ' ' . $etat ?></p>
            <?php endif; ?>
            
            <?php if(isset($date) && isset($date_fin) && $date!= 0 && $date_fin!= 0): ?>
                <p><?php echo 'Date de début : ' . $date ?></p>
                <p><?php echo 'Date de fin : ' . $date_fin ?></p>
                <p><?php echo $type . ' ' . $prix . '€'?></p>
                <?php endif; ?>    
            </p>
        </div>
    </div>
</div>
    <!--Affichage des détails de l'annonce -->
    <div class="container header-padding">
        <p class="fs-5"><strong>Description</strong></p>
        <p class="fs-6"><?php echo $description; ?></p>
    </div>

    <!--Affichage des détails de l'annonce -->
    <div class="container">
        <p class="fs-5"><strong>Coordonnées</strong></p>
        <p class="fs-6"><?php echo $adresse_postal; ?></p>
        <p class="fs-6"><?php echo $email; ?></p>
    </div>
</div>

<?php if(!empty($_COOKIE['userid'])): ?>
    <div class="container">
        <button class="btn btn-dark btn-lg mb-4">Contacter</button>
    </div>
    <!--Formulaire de signalement-->
    <div class="container">
        <form action="#">
            <div class="mb-3">
                <label for="signalement" class="col-sm-2 col-form-label fs-5">Raison du signalement</label>
                <div class="col-sm-10">
                    <textarea name="signalement" class="form-control" cols="5" rows="5" placeholder="Veuillez décrire la raison"></textarea>
                </div>
            </div>
        </form>
        <div class="mb-3" class="col-sm-2 col-form-label">
            <?php echo '<a  href=signalement_traitement.php?id='.$id_annonce.'">'?>
                <input type="submit" role="button" aria-disabled="false" class="btn">
            </a>
        </div>
    </div>
<?php endif; ?>


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

    * {
        margin : 0;
        padding : 0;
        box-sizing:border-box;
    }

    img{
        max-width:400px;
        float:left;
        margin-right:10px;
    }

    .wrapper{
        margin:150px auto;
        width:70%;
    }

    .title-custom{
        margin-bottom : 60px;
    }

    .margin-custom{
        margin-top :200px;
    }
</style>
<!--Script bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>