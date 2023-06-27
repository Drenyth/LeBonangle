<!-- Traitement du formulaire de modification de mot de passe-->
<?php
    require_once 'config.php';
    //récupération user id et données correspondantes
    if(!empty($_COOKIE['userid']))
    {
        $userid = $_COOKIE['userid'];

        $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
        $req->execute(array($userid));
        $data = $req->fetch();

        $email = $data['email'];
        $ip = $data['ip'];
        $prenom = $data['prenom'];
        $nom = $data['nom'];
        $genre = $data['genre'];
        $date_de_naissance = $data['date_de_naissance'];
        $pays = $data['pays'];
        $adresse = $data['adresse'];
        $code_postal = $data['code_postal'];
        $favoris = $data['favoris'];
        $interets = $data['interets'];
        $token = $data['token'];
        $date_creation = $data['date_inscription'];
    }
    else
    {
        $userid = false;
    }

    if(!empty($_POST['password']) && !empty($_POST['password_retype']))
    {
        $password = htmlspecialchars($_POST['password']);
        $password_retype = htmlspecialchars($_POST['password_retype']);
 
            
            if($password == $password_retype){
                
                //requete recuperant les données de l'utilisateur
                $check = $bdd->prepare('SELECT prenom, nom, password FROM utilisateurs WHERE id = ?');
                $check->execute(array($userid));
                $data = $check->fetch();
                $row = $check->rowCount();

                //suppression des données de l'utilisateur
                $check = $bdd->prepare('DELETE FROM utilisateurs WHERE id = ?');
                $check->execute(array($userid));

                //encryptage du mot de passe en utilisant la technologie BCRYPT
                $cost = ['cost' => 12];
                $password = password_hash($password, PASSWORD_BCRYPT, $cost);
                
                //insertion des données nouvelles données de l'utilisateur
                $insert = $bdd->prepare('INSERT INTO utilisateurs(id, email, password, ip, prenom, nom, genre, date_de_naissance, pays, adresse, code_postal, favoris, interets, token, date_inscription) VALUES(:id, :email, :password, :ip, :prenom, :nom, :genre, :date_de_naissance, :pays, :adresse, :code_postal, :favoris, :interets, :token, :date_inscription)');
                $insert->execute(array(
                    'id' => $userid,
                    'email' => $email,
                    'password' => $password,
                    'ip' => $ip,
                    'prenom' => $prenom,
                    'nom' => $nom,
                    'genre' => $genre,
                    'date_de_naissance' => $date_de_naissance,
                    'pays' => $pays,
                    'adresse' => $adresse,
                    'code_postal' => $code_postal,
                    'favoris' => $favoris,
                    'interets' => $interets,
                    'token' => $token,
                    'date_inscription' => $date_creation
                ));
                unset($_COOKIE['userid']);
                setcookie('userid', '', time() - 10);
                header('Location:connexion.php?reg_err=success');
                die();
            }else {header('Location:mot_de_passe.php?reg_err=password'); die();}
        }