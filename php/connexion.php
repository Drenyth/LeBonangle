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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
<nav class="navbar navbar-expand-md navbar-custom header-padding">
    <div class="container justify-content-center">
    <a href="landing.php" class="navbar-brand">
        <img class="d-inline-block center" src="../images/logo.png" width="80">
    </a>
        <button class="navbar-toggler me-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#btn">
            <i class="bx bx-menu bx-md"></i>
        </button>
    <div class="collapse navbar-collapse flex-grow-1" id="btn">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
            <a href="inscription.php" class="btn btn-dark btn-lg">S'inscrire</a>
            </li>
        </ul>
    </div>
    </div>
</nav>


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
    <!-- Option 1: Bootstrap Bundle with Popper -->
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