<form action="annonce_suppression.php" method='POST'>
    <div class="form-group">
        <label for="id_annonce" id = "bold">id annonce</label>
        <input type="text" name="id_annonce" title = "Numéro à 10 chiffres sans espace et commençant par 06 ou 07" class="form-control" placeholder = "id" required>
    </div>

    <div class="form-group">
        <button type="submit" name="submit" role="button" aria-disabled="false" class="btn">supprimer</button>
    </div>
</form>