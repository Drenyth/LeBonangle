<?php
    require_once "config.php";
    $id_annonce = $_POST['id_annonce'];
    $delete = $bdd->prepare('DELETE FROM annonce  WHERE id_annonce = :id_annonce;');
    $delete->execute(array(
        'id_annonce'=>$id_annonce
    ));

    
?>