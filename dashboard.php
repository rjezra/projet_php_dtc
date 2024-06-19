<?php 
require('elements/header.php');
require_once('./function/function.php');
forcer_utilisateur_connecte();
$resultusers = listeUser($pdo);
$listCongers = listeCongers($pdo);
$listePresences = listePresence($pdo);
$results = null;

if (isset($_POST['afficher']) && isset($_POST['id_afficher'])) {
    $id = $_POST['id_afficher'];
    $results = informationPersonnelleUtilisateur($pdo, $id);
   
}
if (isset($_POST['supprimer']) && isset($_POST['id_supprimer'])) {
    $id = $_POST['id_supprimer'];
    supprimerUtilisateur($pdo, $id);
}
if (isset($_POST['valider']) && isset($_POST['id_valider'])) {
    $id = $_POST['id_valider'];
    isEnable($pdo, $id);
    initialisationConger($pdo, $id);
   
}
if (isset($_POST['edit']) && isset($_POST['id_edit'])) {
    $id = $_POST['id_edit'];
    header("Location: update.php?id=$id");
    exit;
}
if(isset($_POST['congerValider']) && isset($_POST['id_valider'])){
    $id = $_POST['id_valider'];
    $idp = $_POST['id_users'];
    validationConger($pdo, $id);
    calculConger($pdo, $idp);
}
if(isset($_POST['reffuserValider']) && isset($_POST['id_valider'])){
    $id = $_POST['id_valider'];
    $idp = $_POST['id_users'];
    reffuserConger($pdo, $id);
}

if(isset($_POST['afficherconger']) && isset($_POST['id_afficherconger']))
{
    $id = $_POST['id_afficherconger'];
    $result = informationPersonnelleUtilisateurConger($pdo, $id);
}
?>
<?php require('./elements/sidebar.php'); ?>



