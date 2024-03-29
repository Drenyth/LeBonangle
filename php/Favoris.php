<!-- Page affichant les annonces misent en favoris de l'utilisateur-->
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

    //requete recuperant les donnees de l'utilisateur
    $check = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
    $check->execute(array($userid));
    $data = $check->fetch();

    //requete recuperant les donnees des annonces
    $check_annonces = $bdd->prepare('SELECT * FROM annonce'); 
    $check_annonces->execute();
    $data_annonces = $check_annonces->fetchAll();
    $row_data_annonces = $check_annonces->rowCount();

    //requete recuperant les favoris de l'utilisateur
    $check_favoris = $bdd->prepare('SELECT * FROM favoris WHERE id_utilisateur = ? ORDER BY id_annonce DESC');
    $check_favoris->execute(array($userid));
    $data_favoris = $check_favoris->fetchAll();
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
                <a href="mes_annonces.php" class="btn btn-dark btn-md">Mes annonces</a>
                <a href="modification.php" class="btn btn-dark btn-md">Mon compte</a>
                <a href="deconnexion.php" class="btn btn-dark btn-md">Déconnexion</a>
            </li>
        </ul>
    </div>
    </div>
</nav>

<?php if($row_data_annonces != 0): ?>
    <!-- parcourt de tous les favoris-->
    <?php foreach($data_favoris as $row_favoris): ?>
        <!-- parcourt de toutes les annonces-->
        <?php foreach($data_annonces as $row_annonce): ?>
            <!-- Affichage de l'annonce dans la page favoris si l'id de l'annonce est dans les fabvoris-->
            <?php if($row_annonce[0] == $row_favoris[1]): ?>
                    <div class="container">
                        <!--$row_annonce[0] est le champ contenant l'id de l'annonce -->
                        <?php echo '<a id="annonce" href="annonce_detail.php?id='.$row_annonce[0].'">';?>
                        <div class="card gy-2 gx-3 border texte-white mb-4" style="background-color:#333333;">
                            <div class="row">
                                <div class="col-md-2">
                                    <!--$row_annonce[3] est le champ contenant la photo de l'annonce -->
                                    <?php  echo '<img class="img-fluid rounded-start" height="150" src="'.$row_annonce[3].'" />';?>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                       <h3 class="card-title header-padding">                                        
                                        <strong>
                                            <!--$row_annonce[2] est le champ contenant le titre de l'annonce -->
                                            <?php echo $row_annonce[2];?>
                                        </strong></h3>
                                        <!--$row_annonce[5] est le champ contenant le prix de l'annonce -->
                                       <p class="card-text"><?php echo $row_annonce[5]."€";?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
            <?php endif;
        endforeach;
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
        /*padding-left:385px;*/
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