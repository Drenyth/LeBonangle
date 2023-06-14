<?php
    if(!empty($_COOKIE['userid']))
    {
        $userid = $_COOKIE['userid'];
        require_once "config.php";
    
        $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
        $req->execute(array($userid));
        $data = $req->fetch();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dépot d'annonce</title>
    <link rel="stylesheet" href=".././css/style-depot_annonce.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Roboto&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <header>
        <div class="inner_header">
            <div class="logo_container">
                <?php if ($userid): ?>  
                    <a href="landing.php"><img id="image" src=".././images/logo_temporaire" alt="LOGO"></a>
                <?php else: ?>
                    <a href="../index.html"><img id="image" src=".././images/logo_temporaire" alt="LOGO"></a>
                <?php endif; ?>
            </div>

            <ul class="navigation">
                <?php if ($userid): ?>
                    <h1>Bonjour <?php echo $data['prenom'] . " " . $data['nom']; ?> !</h1>
                    <a href="deconnexion.php" class="btn btn-danger btn-lg">Déconnexion</a>
                <?php else: ?>
                    <li><a href="connexion.php" id="log">Se connecter</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </header>
    
    <div class="form">
        <form action="destination.html">       
                <div class="form-group">
                    <label for="announcement">Intitulé de l'annonce</label>
                    <input type="text" name="announcement" class="form-control" placeholder="Annonce" required>
                </div>    
    
                <div class="form-group">
                    <label for="image">Choisir une photo</label>
                    <input type="file" name="image" class="form-control" accept="image/png, image/jpeg" required>
                </p>
    
                <div class="form-group">
                    <label for="tags">Tags pour l'annonce :</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="tags[]" value="Automobile">
                        <label class="form-check-label" for="inlineCheckbox1">Sport</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="tags[]" value="Automobile">
                        <label class="form-check-label" for="inlineCheckbox1">Voiture</label>
                    </div>
                </div>
    
                <div class="form-group">
                    <label for="description">Description de l'annonce</label>
                    <textarea name="description" class="form-control" cols="30" rows="10" placeholder="Description" required></textarea>
                </div>
    
                <div class="form-group">
                    <label for="price">Prix</label>
                    <input type="texte" name="price" class="form-control" placeholder="Prix" required>
                </div>
                <div class="form-group">
                    <label for="mail">Adresse mail</label>
                    <input type="email" name="mail" class="form-control" placeholder="Adresse mail" required>
                </div>
                   
                <div class="form-group">     
                    <label for="postal">Code postal</label>
                    <input type="text" name="postal" class="form-control" placeholder="95570" required>
                </div>
    
                <div class="form-group">
                    <label for="adress">Adresse</label>
                    <input type="text" name="adress" class="form-control" placeholder="Adresse" required>
                </div>
    
                <div class="form-group">
                    <label for="phone" id = "bold">Téléphone portable</label>
                    <input type="text" name="phone" title = "Numéro à 10 chiffres sans espace et commençant par 06 ou 07" class="form-control" placeholder = "Numéro" pattern="(06)[0-9]{8}|(07)[0-9]{8}" required>
                </div>
    
                <div class="form-group">
                    <button type="submit" name="submit" role="button" aria-disabled="false" class="btn">Envoyer</button>
                    <input type="Reset" name="reset" value="Réinitialiser" class="btn">
                </div>
        </form>
    </div>

    <script src=".././js/formulaire_depot_annonce.js"></script>

    <style>
        body{
        background-color: #333333;
        min-width: 1400px;
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
        </style>
</body>
</html>