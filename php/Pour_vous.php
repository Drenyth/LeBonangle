<!-- Page affichant les annonces correspondantes aux centres d'interets de l'uitlisateur-->
<!-- récupération user id et données correspondantes -->
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

    //recuperation des donnees utilisateurs
    $check = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
    $check->execute(array($userid));
    $data = $check->fetch();

    //recuperation des donnees des annonces
    $check_annonces = $bdd->prepare('SELECT * FROM annonce ORDER BY id_annonce DESC'); 
    $check_annonces->execute();
    $data_annonces = $check_annonces->fetchAll();
    $row_data_annonces = $check_annonces->rowCount();
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
                <a href="Favoris.php" class="btn btn-dark btn-md">Favoris</a>
                <a href="mes_annonces.php" class="btn btn-dark btn-md">Mes annonces</a>
                <a href="modification.php" class="btn btn-dark btn-md">Mon compte</a>
                <a href="deconnexion.php" class="btn btn-dark btn-md">Déconnexion</a>
            </li>
        </ul>
    </div>
    </div>
</nav>
<!--Gestion des erreurs lié a la suppression d'annonce -->
<div class="supp-form">
    <?php 
    if(isset($_GET['reg_err']))
    {
        $err = htmlspecialchars($_GET['reg_err']);

        switch($err)
        {
            case 'success':
            ?>
                <div class="alert alert-danger">
                    <strong>Erreur</strong> L'annonce a bien été supprimé
                </div>
            <?php
            break;

            case 'failure':
            ?>
                <div class="alert alert-danger">
                    <strong>Erreur</strong> Erreur, l'annonce n'a pas pu être supprimé
                </div>
            <?php
            break;
        }
    }
    ?> 
</div>

<?php if($row_data_annonces != 0): ?>
    <?php foreach($data_annonces as $row): ?>
        <?php 
        //$data[12] contient les centres d'interets de l'utilisateur et $row[8] contient le tag de l'annonce, 
        //ceci permet donc d'afficher les annonces correspondant aux centres d'interets de l'utilisateur
        if(str_contains($data[12],$row[8])): ?>
                    <div class="container">
                        <?php 
                        //$row[0] est le champ contenant l'id de l'annonce
                        echo '<a id="annonce" href="annonce_detail.php?id='.$row[0].'">';?>
                        <div class="card gy-2 gx-3 border texte-white mb-4" style="background-color:#333333;">
                            <div class="row">
                                <div class="col-md-2">
                                    <?php  
                                    //$row[3] est le champ contenant l'image de l'annonce
                                    echo '<img class="img-fluid rounded-start" height="150" src="'.$row[3].'" />';?>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                       <h3 class="card-title header-padding">                                        
                                        <strong>
                                            <?php
                                            //$row[2] est le champ contenant le titre de l'annonce 
                                            echo $row[2];?>
                                        </strong></h3>
                                       <p class="card-text"><?php 
                                       //$row[5] est le champ contenant le prix de l'annonce
                                       echo $row[5]."€";?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
        <?php endif;
    endforeach;
endif; ?>
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

    #annonce{
        text-decoration: none;
        color: white;
    }

    #modif{
        background-color: #333333;
    }

    .header-padding{
            margin-bottom: 4%;
    }
</style>
<!--Script bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>