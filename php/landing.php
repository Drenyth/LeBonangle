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
    <title>Le BonAngle</title>
    <link rel="stylesheet" href=".././css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="inner_header">
            <div class="logo_container">
                <a href="index.html"><img id="image" src=".././images/logo_temporaire" alt="LOGO"></a>
            </div>

            <ul class="navigation">
                <h1>Bonjour <?php echo $data['prenom'] . " " . $data['nom']; ?> !</h1>
                <a href="modification.php" class="btn btn-danger btn-lg">Modification</a>
                <a href="deconnexion.php" class="btn btn-danger btn-lg">Déconnexion</a>
            </ul>
        </div>
    </header>
    
    <div class="boutons">
        <div class="deposer_annonce">
            <a href="formulaire_depot_annonce.php"><button>Déposer une annonce</button></a>
        </div>
        <div class="div_barre_recherche">
            <input id="recherche" name="search_text" onblur="getVal()" placeholder="Rechercher des annonces" autocomplete="off">
            <p> 
                <select name="filtres" id="filtres">
                    <option value="Tous">Tous</option> 
                    <option value="Sport">Sport</option>  
                    <option value="Services">Services</option> 
                </select>
            </p>
        </div>
    </div>
    <div class="annonces">
        <ul>
            <li id="announcement">Annonce 1</li>
            <li id="announcement">Annonce 2</li>
            <li id="announcement">Annonce 3</li>
            <li id="announcement">Annonce 4</li>
            <li id="announcement">Annonce 5</li>
        </ul>
    </div>
    <script src=".././js/index.js"></script>
</body>
</html>