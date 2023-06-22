<?php
    require_once 'config.php';
    //récupération user id et données correspondantes
    if(!empty($_COOKIE['userid']))
    {
        $userid = $_COOKIE['userid'];

        $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
        $req->execute(array($userid));
        $data = $req->fetch();
    }
    else
    {
        $userid = false;
    }
    //requete recuperant les annonces par ordre decroissant (c'est-a-dire de la plus recente a la plus ancienne)
    $check_annonces = $bdd->prepare('SELECT * FROM annonce ORDER BY id_annonce DESC'); 
    $check_annonces->execute();
    $data_annonces = $check_annonces->fetchAll();
    $row_data_annonces = $check_annonces->rowCount();

    //recuperation des informations du formulaire de filtrage
    $selected = $_POST['filtres'];
    $recherche = $_POST['recherche'];

    if(!isset($_GET['page'])){
        $page=1;
        $lim=5;
    }
    else
    {
        $page=intval($_GET['page']);
        $lim = 5 * $page;
    }

    //variables utilisées pour la pagination
    $i=5*($page-1); 
    $x=$page;
    $y=1;
    $previous=$page-1;
    $next=$page+1;

    //recuperation du nombre de page necessaire pour la pagination
    $nb_page = ceil($row_data_annonces / 5);

    //s'il n'y a pas de page défini on est sur la premiere donc on definit les variables en fonction
    if(!isset($_GET['page'])){
        $page=1;
        $lim=5;
    }
    else
    {
        $page=intval($_GET['page']);
        $lim = 5 * $page;
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
                <?php if ($userid): ?>
                <h2><?php echo $data['prenom'] . " " . $data['nom']; ?></h2>
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

<div class="container">
        <div class="col-auto mb-3">
            <a href="annonce_depot.php"><input type="button" role="button" aria-disabled="false" value="Déposer" class="btn"></a>
        </div>
    <form class="row gy-2 gx-3 align-items-center" action="landing_filtre.php" method="post">
        <div class="col-auto mb-3">
        <input type="search" name="recherche" class="form-control" placeholder="Rechercher" autocomplete="off">
        </div>
        <div class="col-auto mb-3">
        <select name="filtres" class="selectpicker">
                <option value ="default"selected>Choisissez un filtre</option>
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
        <div class="col-auto mb-3">
        <button class="btn" type="submit">Rechercher</button>
        </div>
    </form>
</div>

<?php
    //4 cas pour le filtrage
    //cas ou un filtre a ete selectionné et que la barre de recherche est vide
    if($selected != "default" and empty($_POST['recherche'])){
        if($row_data_annonces != 0){
            foreach($data_annonces as $row):?>
                <?php 
                //$row[8] est le champ contenant le tag de l'annonce
                if($selected == $row[8]):?>
                    <div class="container">
                        <?php 
                        //$row[0] est le champ contenant l'id de l'annonce
                        echo '<a id="annonce" href="annonce_detail.php?id='.$row[0].'">'?>
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
                <?php 
                endif; 
            endforeach;
        }
    }
    //cas ou un filtre a ete selectionné et que la barre de recherche n'est pas vide
    //explications des differents row dans le premier cas du filtrage (ligne 130)
    elseif($selected != "default" and isset($_POST['recherche'])){
        if($row_data_annonces != 0){
            foreach($data_annonces as $row): ?>
                <!--str_tolower permet de ne pas etre gener par les majusculer -->
                <?php if($selected == $row[8] and str_contains(strtolower($row[2]),strtolower($recherche))): ?>
                    <div class="container">
                        <?php echo '<a id="annonce" href="annonce_detail.php?id='.$row[0].'">'?>
                        <div class="card gy-2 gx-3 border texte-white mb-4" style="background-color:#333333;">
                            <div class="row">
                                <div class="col-md-2">
                                    <?php  echo '<img class="img-fluid rounded-start" height="150" src="'.$row[3].'" />';?>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                       <h3 class="card-title header-padding">                                        
                                        <strong>
                                            <?php echo $row[2];?>
                                        </strong></h3>
                                       <p class="card-text"><?php echo $row[5]."€";?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                         </a>
                    </div>
                <?php endif; 
            endforeach; 
        }
    }
    //cas ou il n'y a pas de filtre selectionné et que la barre de recherche est vide
    //explications des differents row dans le premier cas du filtrage (ligne 130)
    elseif($selected == "default" and empty($_POST['recherche'])){
        if($row_data_annonces != 0){
            for($i;$i<$lim;$i++): ?>
                         <div class="container">
                            <?php echo '<a id="annonce" href="annonce_detail.php?id='.$data_annonces[$i][0].'">'?>
                            <div class="card gy-2 gx-3 border texte-white mb-4" style="background-color:#333333;">
                                <div class="row">
                                    <div class="col-md-2">
                                        <?php  echo '<img class="img-fluid rounded-start" height="150" src="'.$data_annonces[$i][3].'" />';?>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                           <h3 class="card-title header-padding">                                        
                                            <strong>
                                                <?php echo $data_annonces[$i][2];?>
                                            </strong></h3>
                                           <p class="card-text"><?php echo $data_annonces[$i][5]."€";?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             </a>
                        </div>
            <?php endfor;
        }
    
    }
    //cas ou il n'y pas de filtre selectionné et que la barre de recherche n'est pas vide
    //explications des differents row dans le premier cas du filtrage (ligne 130)
    elseif($selected == "default" and !empty($_POST['recherche'])){
        if($row_data_annonces != 0){
            foreach($data_annonces as $row): ?>
                <!--str_tolower permet de ne pas etre gener par les majusculer -->
                <?php if(str_contains(strtolower($row[2]),strtolower($recherche))): ?>
                    <div class="container">
                        <?php echo '<a id="annonce" href="annonce_detail.php?id='.$row[0].'">'?>
                        <div class="card gy-2 gx-3 border texte-white mb-4" style="background-color:#333333;">
                            <div class="row">
                                <div class="col-md-2">
                                    <?php  echo '<img class="img-fluid rounded-start" height="150" src="'.$row[3].'" />';?>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                       <h3 class="card-title header-padding">                                        
                                        <strong>
                                            <?php echo $row[2];?>
                                        </strong></h3>
                                       <p class="card-text"><?php echo $row[5]."€";?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                         </a>
                    </div>
                <?php endif; 
            endforeach;
        }
    }
?>

<?php 
if(isset($nb_page)){
    //affichage des boutons de pagination seulement s'il y a plus d'une page
    if($nb_page > 1): ?>
        <div class="container">
            <ul class="pagination justify-content-center">
                <?php 
                if($x == 1){
                    echo '<li class="page-item disabled"><a class="page-link" href="landing.php">Previous</a></li>';
                }
                else{
                    echo '<li class="page-item"><a class="page-link" href="landing.php?page='.$previous.'">Previous</a></li>';
                }
        
                for($y;$y<=$nb_page;$y++)
                {
                    echo '<li class="page-item"><a class="page-link" href="landing.php?page='.$y.'">'.$y.'</a></li>';
                }
                if($x == $nb_page){
                    echo '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
                }
                else{
                    echo '<li class="page-item"><a class="page-link" href="landing.php?page='.$next.'">Next</a></li>';
                }
                ?>
            </ul>
        </div>
    <?php endif;
} ?>

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
        #annonce{
            text-decoration: none;
            color: white;
            cursor: pointer;
        }
        #annonce:hover{
            transform: scale(2);
        }

        .header-padding{
            margin-bottom: 4%;
        }
</style>
<!--Script bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>