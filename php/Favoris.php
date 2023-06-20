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
        <img class="d-inline-block center" src="../images/logo.png" width="80">
    </a>
        <button class="navbar-toggler me-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#btn">
            <i class="bx bx-menu bx-md"></i>
        </button>
    <div class="collapse navbar-collapse flex-grow-1" id="btn">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <h1><?php echo $data['prenom'] . " " . $data['nom']; ?></h1>
                <a href="modification.php" class="btn btn-dark btn-lg">Mon compte</a>
                <a href="deconnexion.php" class="btn btn-dark btn-lg">Déconnexion</a>
            </li>
        </ul>
    </div>
    </div>
</nav>

<?php
$check = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
$check->execute(array($userid));
$data = $check->fetch();

$check_annonces = $bdd->prepare('SELECT * FROM annonce'); 
$check_annonces->execute();
$data_annonces = $check_annonces->fetchAll();
$row_data_annonces = $check_annonces->rowCount();

$check_favoris = $bdd->prepare('SELECT * FROM favoris WHERE id_utilisateur = ?');
$check_favoris->execute(array($userid));
$data_favoris = $check_favoris->fetchAll();?>

<?php if($row_data_annonces != 0): ?>
    <?php foreach($data_favoris as $row_favoris): ?>
        <?php foreach($data_annonces as $row_annonce): ?>
            <?php if($row_annonce[0] == $row_favoris[1]): ?>
                <?php echo '<a id="annonce" href="annonce_detail.php?id='.$row_annonce[0].'">'?>
                    <div class="container">
                        <form class="row gy-2 gx-3 align-items-center border mb-4">
                            <div class="col-auto mb-3">
                            <?php  echo '<img width="200" src="'.$row_annonce[3].'" />';?>
                            </div>
                            <div class="col-auto mb-3">
                                <div class="row gy-2 gx-3 align-items-center mb-4">
                                    <h2>
                                        <strong>
                                            <?php echo $row_annonce[2];?>
                                        </strong>
                                    </h2>
                                </div>
                                <div class="row gy-2 gx-3 align-items-center  mb-4">
                                    <?php echo $row_annonce[5]."€";?>
                                </div>
                            </div>
                        </form>
                    </div>
                </a>
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
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>