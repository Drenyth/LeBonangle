<?php
    require_once "config.php";
    if( $id_annonce = $_GET['id']){
    $delete = $bdd->prepare('DELETE FROM annonce  WHERE id_annonce = :id_annonce;');
    $delete->execute(array(
        'id_annonce'=>$id_annonce
    ));
    $request = $bdd->prepare('SELECT * FROM bien WHERE id_annonce = ?');
    $request->execute(array($id_annonce));
    $bien = $request->fetch();
    $row = $request->rowCount();

    if(($row != 0)){
        $check1 = $bdd->prepare('DELETE FROM bien WHERE id_annonce = ?');
        $check1->execute(array($id_annonce));
    }
    else{
        $check1 = $bdd->prepare('DELETE FROM service WHERE id_annonce = ?');
        $check1->execute(array($id_annonce));
    }
    header('Location:mes_annonces.php?supp_err=success');die();
}
else {
    header('Location:mes_annonces.php?supp_err=failure');die();
}
    
?>