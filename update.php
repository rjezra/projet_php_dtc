<?php
$titre = "Acceuil";
require('elements/header.php');
require_once('./function/function.php');
$id = $_GET['id'];
$listeedit = listeUserEdit($pdo, $id);
if(isset($_POST['submit'])){
    updateUtilisateur($pdo, $id);
    header('Location:dashbord.php');
    exit();
}

?>
<div class="container">
<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Entre votre nom</label>
        <input type="text" name="nom" class="form-control" id="exampleFormControlInput1" placeholder="Entre votre nom" value="<?=htmlentities($listeedit['nom'])?>">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Entre votre prenom</label>
        <input type="text" name="prenom" class="form-control" id="exampleFormControlInput1" placeholder="Entre votre prenom" value="<?=htmlentities($listeedit['prenom'])?>">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Entre votre pseudo</label>
        <input type="text" name="pseudo" class="form-control" id="exampleFormControlInput1" placeholder="Entre votre pseudo" value="<?=htmlentities($listeedit['pseudo'])?>">
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary" data-mdb-ripple-init name="submit">Enregistrer</button>
    </div>
</form>

<?php require('./elements/footer.php'); ?>