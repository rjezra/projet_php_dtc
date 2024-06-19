<?php
$titre = "Acceuil";
require('elements/header.php');
require_once('./function/function.php');
?>
<div class="container">
<?php
if (isset($_POST['submit'])) {
  loginUtilisateur($pdo);
  if (est_connecte()) {
    header('Location:profil.php');
    exit();
  }
}
?>

  <section>
    <div class="row d-flex justify-content-center align-items-center h-200 ">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="../assests/img/draw2.webp" class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form action="" method="post">
          <!-- Username input -->
          <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="form3Example3">Pseudo</label>
            <input type="text" id="form3Example3" class="form-control form-control-lg" name="pseudo" placeholder="Entrer votre Pseudo" />
          </div>

          <!-- Password input -->
          <div data-mdb-input-init class="form-outline mb-3">
            <label class="form-label" for="form3Example4">Mots de passe</label>
            <input type="password" id="form3Example4" name="mdp" class="form-control form-control-lg" placeholder="Entrer votre Mots de passe" />
          </div>
          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" name="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary rounded-pill px-6" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
            <a href="./inscription.php" class="btn btn-success rounded-pill px-10">Inscription</a>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>


<?php require('./elements/footer.php'); ?>