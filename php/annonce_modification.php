<?php
    require_once 'config.php';

    $id_annonce = $_GET['id'];

    if(!empty($_COOKIE['userid']))
    {
        
        $userid = $_COOKIE['userid'];
        require_once 'config.php';
        
        $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
        $req->execute(array($userid));
        $data = $req->fetch();

        if(!empty($id_annonce)){
            $check = $bdd->prepare('SELECT * FROM annonce WHERE id_annonce = ? AND id_utilisateur= ?');
            $check->execute(array($id_annonce,$userid));
            $data_annonce = $check->fetch();
            if ($data_annonce) {
                // Le fetch a réussi, vous pouvez accéder aux éléments du tableau
                $id_utilisateur = $data_annonce['id_utilisateur'];
                $nom_annonce = $data_annonce['nom_annonce'];
                $photo = $data_annonce['photo'];
                $description = $data_annonce['description'];
                $prix = $data_annonce['prix'];
                $email = $data_annonce['email'];
                $adresse_postal = $data_annonce['adresse_postal'];
                $tags = $data_annonce['tags'];

                // Gestion Bien ou Service 
                //Bien
                $check = $bdd->prepare('SELECT * FROM bien WHERE id_annonce = ?');
                $check->execute(array($id_annonce));
                $data_type_annonce = $check->fetch();
                $row_type = $check->rowCount();
                if($row_type != 0){
                    $typebien = $data_type_annonce['type'];
                    $etat = $data_type_annonce['etat'];
                    $typeannonce = "bien";
                }
                //Service
                else{
                    $check = $bdd->prepare('SELECT * FROM service WHERE id_annonce = ?');
                    $check->execute(array($id_annonce));
                    $data_type_annonce = $check->fetch();
                    $row_type = $check->rowCount();
                    if($row_type != 0){
                        $date = $data_type_annonce['date'];
                        $date_fin = $data_type_annonce['date_fin'];
                        $typeannonce ="service";
                    }
                    else {
                        // Le fetch n'a renvoyé aucun résultat (error debugging tool)
                        echo "Aucun bien ou service trouvée pour $nom_annonce";
                    }
                }
            } else {
                // Le fetch n'a renvoyé aucun résultat (error debugging tool)
                echo "Aucune annonce trouvée avec l'identifiant $id_annonce et id_utilisateur $userid";
            }
        }
        else{
            $id_annonce = false ;
        }
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
    <title>Modification d'annonce</title>
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
        <img class="d-inline-block center" src="../images/logo.png" width="80">
    </a>
        <button class="navbar-toggler me-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#btn">
            <i class="bx bx-menu bx-md"></i>
        </button>
    <div class="collapse navbar-collapse flex-grow-1" id="btn">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <h1><?php echo $data['prenom'] . " " . $data['nom']; ?></h1>
                <a href="mes_annonces.php" class="btn btn-danger btn-lg">Mes annonces</a>
                <a href="modification.php" class="btn btn-danger btn-lg">Mon compte</a>
                <a href="deconnexion.php" class="btn btn-danger btn-lg">Déconnexion</a>
            </li>
        </ul>
    </div>
    </div>
</nav>
<div class="modif-form">
             <?php 
                if(isset($_GET['modif_err']))
                {
                    $err = htmlspecialchars($_GET['modif_err']);
                    switch($err)
                    {
                        case 'success':
                            ?>
                                <div class="alert alert-success">
                                    <strong>Succès</strong> modifications effectuées !
                                </div>
                            <?php
                            break;
                            
                        case 'tags_length':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> tag trop longue
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

                        case 'email_length':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> email trop longue
                            </div>
                        <?php
                        break;

                        case 'description_length':
                            ?>
                                <div class="alert alert-danger">
                                    <strong>Erreur</strong> description trop longue
                                </div>
                        <?php
                        break;
                        case 'annonce_length':
                            ?>
                                <div class="alert alert-danger">
                                    <strong>Erreur</strong> nom annonce trop longue
                                </div>
                        <?php
                        break;
                        case 'void':
                            ?>
                                <div class="alert alert-danger">
                                    <strong>Erreur</strong> L'annonce n'existe pas
                                </div>
                        <?php
                        break;
                        case 'typeannonce':
                            ?>
                                <div class="alert alert-danger">
                                    <strong>Erreur</strong> Le type de bien/service n'existe pas
                                </div>
                        <?php
                        break;
                    }
                }
            ?> 



<div class="container">
<form action="annonce_modification_traitement.php?id=<?php echo $id_annonce; ?>" method="post">
    <div class="mb-3">
        <label for="nom_annonce" class="col-sm-2 col-form-label">Intitulé de l'annonce</label>
        <div class="col-sm-10">
            <input type="text" name="nom_annonce" class="form-control" placeholder="Annonce" value="<?php echo $nom_annonce; ?>" required>
        </div>
    </div>

    <div class="mb-3">         
    <label for="typeannonce" class="col-sm-2 col-form-label">Type d'annonce</label>
        <div class="col-sm-10">
        <input type="radio" name="typeannonce" value="service" <?php if($typeannonce == "service") echo "checked"; ?>>
        <label for="service">Service</label>
        <input type="radio" name="typeannonce" value="bien" <?php if($typeannonce == "bien") echo "checked"; ?>>
        <label for="bien">Bien</label>
        </div>
    </div>

    <div class="mb-3">
    <label for="photo" class="col-sm-2 col-form-label">Choisir une photo</label>
        <div class="col-sm-10">
        <input type="file" name="photo" class="form-control" accept="image/png, image/jpeg" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="tags" class="col-sm-2 col-form-label">Tags pour l'annonce :</label>
        <select name="tags" class="selectpicker">
            <option selected>Choisissez un tag</option>
            <<option value="Immobilier" <?php if($tags == "Immobilier") echo "selected"; ?>>Immobilier</option>
            <option value="Automobile" <?php if($tags == "Automobile") echo "selected"; ?>>Automobile</option>
            <option value="Lecture" <?php if($tags == "Lecture") echo "selected"; ?>>Lecture</option>
            <option value="Mode" <?php if($tags == "Mode") echo "selected"; ?>>Mode</option>
            <option value="Bricolage" <?php if($tags == "Bricolage") echo "selected"; ?>>Bricolage</option>
            <option value="Jeux" <?php if($tags == "Jeux") echo "selected"; ?>>Jeux</option>
            <option value="Sport" <?php if($tags == "Sport") echo "selected"; ?>>Sport</option>
            <option value="Musique" <?php if($tags == "Musique") echo "selected"; ?>>Musique</option>
        </select>
    </div>
                
    <div class="mb-3">
    <label for="description" class="col-sm-2 col-form-label">Description de l'annonce</label>
        <div class="col-sm-10">
        <textarea name="description" class="form-control" cols="30" rows="10" placeholder="Description" required> <?php echo $description;?></textarea>
        </div>
    </div>

    <div class="mb-3">
    <label for="prix" class="col-sm-2 col-form-label">Prix</label>
        <div class="col-sm-10">
            <input type="text" name="prix" class="form-control" placeholder="Prix" value="<?php echo $prix; ?>"required>
        </div>
    </div>

    <div class="mb-3">
    <label for="email" class="col-sm-2 col-form-label">Adresse mail</label>
        <div class="col-sm-10">
            <input type="email" name="email" class="form-control" placeholder="Adresse mail" value="<?php echo $email; ?>" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="adresse_postal" class="col-sm-2 col-form-label">Adresse</label>
        <div class="col-sm-10">
            <input type="text" name="adresse_postal" class="form-control" placeholder="Adresse" value="<?php echo $adresse_postal; ?>" required>
        </div>
    </div>
            
    <?php if ($typeannonce == "bien" || ((isset($_POST['typeannonce']) && $_POST['typeannonce'] == "bien"))): ?>     
    <div id="divTypeBien" class="mb-3">
        <label for="typebien" id="bold" class="col-sm-2 col-form-label">Type de Bien</label>
        <div class="col-sm-10">
            <select name="typebien" class="selectpicker">
                    <option selected>Choisissez un filtre</option>
                    <option value="0" <?php if($typebien == "0") echo "selected"; ?>>Location</option>
                    <option value="1" <?php if($typebien == "1") echo "selected"; ?>>Vente</option>
            </select>
        </div>
    </div>
    <?php endif;?>               

    <?php if($typeannonce == "bien" || ((isset($_POST['typeannonce']) && $_POST['typeannonce'] == "bien"))): ?>
    <div id="divEtat" class="mb-3">
        <label for="etat" id="bold" class="col-sm-2 col-form-label">Etat</label>
        <div class="col-sm-10">
            <select name="etat" class="selectpicker">
            <option value="bon" <?php if($etat == "bon") echo "selected"; ?>>Bon</option>
            <option value="moyen" <?php if($etat == "moyen") echo "selected"; ?>>Moyen</option>
            <option value="mauvais" <?php if($etat == "mauvais") echo "selected"; ?>>Mauvais</option>
            </select>
        </div>
    </div> 
    <?php endif;?>

    <?php if($typeannonce == "service" ): ?>  
    <div id="divDateDebut" class="mb-3">
        <label for="date" id="bold" class="col-sm-2 col-form-label">Date</label>
        <div class="col-sm-10">
            <input type="date" name="date" title="" class="form-control" placeholder="date"value="<?php echo $date; ?>">
        </div>
    </div>    
    <div id="divDateFin" class="mb-3">
        <label for="date" id="bold" class="col-sm-2 col-form-label">Date de Fin</label>
        <div class="col-sm-10">
            <input type="date" name="date_fin" title="" class="form-control" placeholder="date"value="<?php echo $date; ?>">
        </div>
    </div>
    <?php endif;?>
    <?php if($typeannonce == "service" ): ?>  
    <div id="divDate" class="mb-3">
        <label for="date_fin" id="bold" class="col-sm-2 col-form-label">Date de fin</label>
        <div class="col-sm-10">
            <input type="date" name="date_fin" title="" class="form-control" placeholder="date de fin"value="<?php echo $date_fin; ?>">
        </div>
    </div>
    <?php endif;?>    
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
    .modif-form {
        width: 70%;
        height: 100%;
        margin-left: 15%;
    }
    .modif-form form {
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
    
    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>




