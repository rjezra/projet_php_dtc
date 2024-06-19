<?php
$titre = "Acceuil";
require('elements/header.php');
require_once('./function/function.php');
if(isset($_POST['submit'])){
    $inputData = inputData($pdo);
    header('Location:index.php');
    exit();
}

?>
<div class="container">
<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Entre votre nom</label>
        <input type="text" name="nom" class="form-control" id="exampleFormControlInput1" placeholder="Entre votre nom">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Entre votre prenom</label>
        <input type="text" name="prenom" class="form-control" id="exampleFormControlInput1" placeholder="Entre votre prenom">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Entre votre pseudo</label>
        <input type="text" name="pseudo" class="form-control" id="exampleFormControlInput1" placeholder="Entre votre pseudo">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Entre votre mot de passe</label>
        <input type="password" name="mdp" class="form-control" id="exampleFormControlInput1" placeholder="Entre votre mot de passe">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Choisisser votre role</label>
        <select class="form-select" aria-label="Default select example" name="role">
            <option selected>Choisisser votre role</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Ajouter votre photo</label>
        <input type="file" name="photo" class="form-control" id="exampleFormControlInput1" placeholder="Ajouter votre photo">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Ajouter votre mail</label>
        <input type="email" name="mail" class="form-control" id="exampleFormControlInput1" placeholder="exemple@mail.com">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Ajouter votre numero de téléphone</label>
        <input type="tel" name="phone" class="form-control" id="exampleFormControlInput1" placeholder="+261 xx xx xxx xx">
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary" data-mdb-ripple-init name="submit">Enregistrer</button>
    </div>
</form>

<?php require('./elements/footer.php'); ?>