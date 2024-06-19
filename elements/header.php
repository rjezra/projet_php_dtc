<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require(__DIR__ . '/../function/menuFunction.php');
require_once (__DIR__ . '/../function/function.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?php if (isset($titre)) : ?>
      <?php echo $titre; ?>
    <?php else :  ?>
      Mon site
    <?php endif ?>
  </title>
  <link rel="stylesheet" href="../assests/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assests/css/style.css">
  <link rel="stylesheet" href="../../assests/css/sidebars.css">
  <link rel="stylesheet" href="../assests/icons/font/bootstrap-icons.min.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-primary fixed-top" data-bs-theme="dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Mon Projet</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <?php if (est_connecte()) : ?>
        <div class="collapse navbar-collapse" id="navbarCollapse">
        
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <?= nav_menu('nav-item') ?>
          </ul>
         
          <ul class="navbar-nav">
            <?php if (admin($pdo)) : ?>
              <li class="nav-item"><a href="dashboard.php" class="nav-link">DASHBOARD</a></li>
            <?php endif ?>
              <li class="nav-item"><a href="deconnexion.php" class="nav-link">Se deconecter</a></li>
          </ul>
        </div>
      <?php endif ?>
    </div>
  </nav>

 