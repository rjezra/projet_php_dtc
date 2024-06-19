<?php
$titre = "Acceuil";
require('elements/header.php');
forcer_utilisateur_connecte();
if (isset($_POST['presence'])) {
  $presence = presenceEntrer($pdo);
}
if (isset($_POST['sortie'])) {
  $presence = presenceSortie($pdo);
}
if(isset($_POST['conger'])){
  $conger = demandeConger($pdo);
}
$result = verificationConger($pdo);
$restConger = verificationResteConger($pdo)
?>
<div class="container">
  <section style="background-color: #f4f5f7;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-lg-6 mb-4 mb-lg-0">
          <div class="card mb-3" style="border-radius: .5rem;">
            <div class="row g-0">
              <div class="col-md-4 gradient-custom text-center img text-primary pdp" style="border-top-left-radius: .5rem; border-radius: .5rem;">
                <img src="./assests/img/<?= htmlentities($_SESSION['photo']) ?>" alt="Avatar" class="img-fluid my-5 " />
                <h5><?= $_SESSION['nom'] ?> <?= htmlentities($_SESSION['prenom']) ?></h5>
                <p><?= $_SESSION['roles'] ?></p>
                <form action="" method="post">
                  <?php if (verificationEntrer($pdo)) : ?>
                    <button class="btn btn-primary <?= verificationSortie($pdo) ? 'd-none' : '' ?>" name="sortie">Sortie</button>
                  <?php else : ?>
                    <button class="btn btn-primary" name="presence">Entre</button>
                  <?php endif ?>
                </form>
              </div>
              <div class="col-md-8">
                <div class="card-body p-4">
                  <h6>Information</h6>
                  <hr class="mt-0 mb-4">
                  <div class="row pt-1">
                    <div class="col-6 mb-3">
                      <h6>Email</h6>
                      <p class="text-muted"><?= htmlentities($_SESSION["mail"])?></p>
                    </div>
                    <div class="col-6 mb-3">
                      <h6>Phone</h6>
                      <p class="text-muted"><?=htmlentities($_SESSION["phone"])?></p>
                    </div>
                  </div>
                  <h6>Conger</h6>
                  <hr class="mt-0 mb-4">
                  <div class="row pt-1">
                   <?php require('./elements/conger.php'); ?>
                  </div>
                  <h6>Nombre de reste de conger</h6>
                  <hr class="mt-0 mb-4">
                  <div class="row pt-1">
                    <div class="col-6 mb-3">
                      <p class="text-muted"> <?=htmlentities($restConger[0]['reste_conger'])?> Jours</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php require('./elements/footer.php'); ?>
</div>