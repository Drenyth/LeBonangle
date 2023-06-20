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
        <img class="d-inline-block center" src="../images/logo.png" width="80">
    </a>
        <button class="navbar-toggler me-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#btn">
            <i class="bx bx-menu bx-md"></i>
        </button>
    <div class="collapse navbar-collapse flex-grow-1" id="btn">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <h1><?php echo $data['prenom'] . " " . $data['nom']; ?></h1>
                <a href="mes_annonces.php" class="btn btn-dark btn-lg">Mes annonces</a>
                <a href="modification.php" class="btn btn-dark btn-lg">Mon compte</a>
                <a href="deconnexion.php" class="btn btn-dark btn-lg">Déconnexion</a>
            </li>
        </ul>
    </div>
    </div>
</nav>
<div class="container">
        <div class="col-auto mb-3">
            <a href="annonce_depot.php"><input type="button" role="button" aria-disabled="false" value="Déposer une annonce" class="btn"></a>
        </div>
    <form class="row gy-2 gx-3 align-items-center" action="landing_filtre.php" method="post">
        <div class="col-auto mb-3">
        <input type="search" name="recherche" class="form-control" placeholder="Rechercher des annonces" autocomplete="off">
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
    session_start();
    require_once 'config.php';
    $check_annonces = $bdd->prepare('SELECT * FROM annonce ORDER BY id_annonce DESC'); 
    $check_annonces->execute();
    $data_annonces = $check_annonces->fetchAll();
    $row_data_annonces = $check_annonces->rowCount();
    $selected = $_POST['filtres'];
    if($selected == "default"){
        if($row_data_annonces != 0){
            foreach($data_annonces as $row): ?>
                        <div class="container">
                            <?php echo '<a id="annonce" href="annonce_detail.php?id='.$row[0].'">'?>
                            <form class="row gy-2 gx-3 align-items-center border mb-4">
                                <div class="col-auto mb-3">
                                <?php  echo '<img height="200" src="'.$row[3].'" />';?>
                                </div>
                                <div class="col-auto">
                                    <div class="row gy-2 gx-3 align-items-center mb-4">
                                        <strong>
                                            <?php echo $row[2];?>
                                        </strong>
                                    </div>
                                    <div class="row gy-2 gx-3 align-items-center  mb-4">
                                        <?php echo $row[5]."€";?>
                                    </div>
                                </div>
                            </form>
                            </a>
                        </div> 
            <?php endforeach; ?>
        <?php }
    }
    else
    {
        if($row_data_annonces != 0){
                foreach($data_annonces as $row): ?>
                    <?php if($selected == $row[8]): ?>
                            <div class="container">
                                <?php echo '<a id="annonce" href="annonce_detail.php?id='.$row[0].'">'?>
                                <form class="row gy-2 gx-3 align-items-center border mb-4">
                                    <div class="col-auto mb-3">
                                    <?php  echo '<img height="200" src="'.$row[3].'" />';?>
                                    </div>
                                    <div class="col-auto">
                                        <div class="row gy-2 gx-3 align-items-center mb-4">
                                            <strong>
                                                <?php echo $row[2];?>
                                            </strong>
                                        </div>
                                        <div class="row gy-2 gx-3 align-items-center  mb-4">
                                            <?php echo $row[5]."€";?>
                                        </div>
                                    </div>
                                </form>
                                </a>
                            </div> 
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php }
    }
?>
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
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>