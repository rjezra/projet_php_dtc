<?php

/**Connexion db */
try {
    $pdo = new PDO("mysql:host=localhost;dbname=db_php_dtc", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

/**Gestions des utilisateur */
function est_connecte(): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return !empty($_SESSION["connecte"]);
}

function forcer_utilisateur_connecte(): void
{
    if (!est_connecte()) {
        header('Location: /index.php');
        exit();
    }
}

function ajoutImage()
{
    $dossier = "./assests/img/";
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $fichier_temporaire = $_FILES['photo']['tmp_name'];
        $nom_fichier = basename($_FILES['photo']['name']);
        $chemin_destination = $dossier . $nom_fichier;
        move_uploaded_file($fichier_temporaire, $chemin_destination);
        return $nom_fichier;
    }
}

function inputData($pdo): string
{
    if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['pseudo']) && !empty($_POST['mdp']) && !empty($_POST['role']) && !empty($_POST['mail']) && !empty($_POST['phone'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $pseudo = $_POST['pseudo'];
        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
        $role = $_POST['role'];
        $phone = $_POST['phone'];
        $mail = $_POST['mail'];
        $isEnable = false;
        $date = date("Y-m-d");
        $photo = ajoutImage();
        if ($role == 'admin') {
            $pseudo = $_POST['pseudo'] . "-Admin";
            $isEnable = true;
        }
        $sql = $pdo->prepare("INSERT INTO users (nom, prenom, pseudo, mdp, isEnable, roles, created_at, photo, mail, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $sql->execute([$nom, $prenom, $pseudo, $mdp, $isEnable, $role, $date, $photo, $mail, $phone]);

        return "Inscription réussie";
    }
    return "Mauvaise inscription";
}

function loginUtilisateur($pdo): void
{
    if (isset($_POST['pseudo'], $_POST['mdp'])) {
        $pseudo = $_POST['pseudo'];
        $mdp = $_POST['mdp'];
        $sql = $pdo->prepare("SELECT * FROM users WHERE pseudo = ?");
        $sql->execute([$pseudo]);
        if ($sql) {
            $result = $sql->fetch(PDO::FETCH_ASSOC);
            if ($result && password_verify($mdp, $result["mdp"])) {
                if ($result["isEnable"] == false) {
                    echo "Votre compte est en attente d'activation.";
                } else {
                    session_start();
                    $_SESSION["connecte"] = true;
                    $_SESSION["id"] = $result["id"];
                    $_SESSION["nom"] = $result["nom"];
                    $_SESSION["prenom"] = $result["prenom"];
                    $_SESSION["photo"] = $result["photo"];
                    $_SESSION["roles"] = $result["roles"];
                    $_SESSION["phone"] = $result["phone"];
                    $_SESSION["mail"] = $result["mail"];
                    header('Location: /profil.php');
                    exit();
                }
            } else {
                echo "Mauvais login ou mot de passe.";
            }
        } else {
            echo "Erreur lors de la connexion à la base de données.";
        }
    } else {
        echo "Veuillez remplir tous les champs du formulaire.";
    }
}

function listeUser($pdo)
{
    $sql = $pdo->prepare("SELECT * FROM users");
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $sql->execute();
    $resultusers = $sql->fetchAll();
    return $resultusers;
}
function admin($pdo): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION["id"])) {
        $id = $_SESSION["id"];
        $sql = $pdo->prepare("SELECT roles FROM users WHERE id = ?");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute([$id]);
        $result = $sql->fetch();
        if ($result && $result["roles"] === "admin") {
            return true;
        }
    }
    return false;
}

function informationPersonnelleUtilisateur($pdo, $id)
{
    try {
        $sql = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $sql->execute([$id]);
        $userData = $sql->fetch(PDO::FETCH_ASSOC);
        return $userData;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

function supprimerUtilisateur($pdo, $id)
{
    try {
        $sql = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $sql->execute([$id]);
         
        return true;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
function updateUtilisateur($pdo, $id)
{
    try {
        $nom = isset($_POST['nom']) ? $_POST['nom'] : null;
        $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : null;
        $pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : null;
        if ($nom === null || $prenom === null || $pseudo === null) {
            throw new Exception("Manquant necessite des donnees pour la mise a jour.");
        }
        $sql = $pdo->prepare("UPDATE users SET nom = ?, prenom = ?, pseudo = ? WHERE id = ?");
        $sql->execute([$nom, $prenom, $pseudo, $id]);
        return true;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
function isEnable($pdo, $id)
{
    try {
        $sql = $pdo->prepare("UPDATE users SET isEnable = 1 WHERE id = ?");
        $sql->execute([$id]);
        return true;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
function listeUserEdit($pdo, $id)
{
    try {
        $sql = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $sql->execute([$id]);
        $user = $sql->fetch(PDO::FETCH_ASSOC);
        return $user;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}


/**Gestions des conger */
function demandeConger($pdo)
{
    try {
        if (!isset($_SESSION["id"])) {
            throw new Exception("Pas de users actifs");
        }
        $id_users = $_SESSION["id"];
        if (!isset($_POST['dateDebut'], $_POST['dateFin'], $_POST['motif'])) {
            throw new Exception("Absence de donnes POST");
        }
        $dateDebut = $_POST['dateDebut'];
        $dateFin = $_POST['dateFin'];
        $motif = $_POST['motif'];
        $dateDebutObj = new DateTime($dateDebut);
        $dateFinObj = new DateTime($dateFin);
        $interval = $dateDebutObj->diff($dateFinObj);
        $nombreJours = $interval->days + 1;
        $acceptation = "en attente";
        $sql = $pdo->prepare("INSERT INTO conger (id_users, date_debut_conger, date_fin_conger, motif_conger, acceptation_conger, nombre_jours_conger) VALUES (?, ?, ?, ?, ?, ?)");
        $sql->execute([$id_users, $dateDebut, $dateFin, $motif, $acceptation, $nombreJours]);
        return $nombreJours;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

function listeCongers($pdo)
{
    try {
        $sql = $pdo->prepare("SELECT * FROM conger JOIN users ON conger.id_users = users.id");
        $sql->execute();
        $listeCongers = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $listeCongers;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

function validationConger($pdo, $id)
{
    try {
        $valConger = "Accepter";
        $sql = $pdo->prepare("UPDATE conger SET acceptation_conger = ? WHERE id_conger = ?");
        $result = $sql->execute([$valConger, $id]);
        if ($result) {
            $sql = $pdo->prepare("SELECT * FROM conger WHERE id_conger = ?");
            $sql->execute([$id]);
            $validation = $sql->fetch(PDO::FETCH_ASSOC);

            return $validation;
        } else {
            return "Erreur de mis a jours";
        }
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
function reffuserConger($pdo, $id){
    try {
        $valConger = "Reffuser";
        $sql = $pdo->prepare("UPDATE conger SET acceptation_conger = ? WHERE id_conger = ?");
        $result = $sql->execute([$valConger, $id]);
        if ($result) {
            $sql = $pdo->prepare("SELECT * FROM conger WHERE id_conger = ?");
            $sql->execute([$id]);
            $validation = $sql->fetch(PDO::FETCH_ASSOC);

            return $validation;
        } else {
            return "Erreur de mis a jours";
        }
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

function informationPersonnelleUtilisateurConger($pdo, $id)
{
    try {
        $sql = $pdo->prepare("
            SELECT users.*, conger.*
            FROM conger
            JOIN users ON conger.id_users = users.id
            WHERE conger.id_conger = ?
        ");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute([$id]);
        $result = $sql->fetchAll();
        return $result;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

function initialisationConger($pdo, $id)
{
    try {
        $nombreConger = 30;
        $sql = $pdo->prepare("INSERT INTO nombreconger (id_users, reste_conger) VALUES (?, ?)");
        $result = $sql->execute([$id, $nombreConger]);
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

function calculConger($pdo, $idp)
{
    try {
        $sql1 = $pdo->prepare("SELECT reste_conger FROM nombreconger WHERE id_users = ?");
        $sql1->execute([$idp]);
        $congerInitial = $sql1->fetch();

        if ($congerInitial === false) {
            throw new Exception("Pas de conger des ulitisateurs");
        }
        $nombreCongerInitial = $congerInitial['reste_conger'];
        $sql2 = $pdo->prepare("SELECT nombre_jours_conger FROM conger WHERE id_users = ? ORDER BY id_conger DESC LIMIT 1");
        $sql2->execute([$idp]);
        $congerLatest = $sql2->fetch();
        if ($congerLatest === false) {
            throw new Exception("Pas de conger des ulitisateurs");
        }
        $nombreJoursConge = $congerLatest['nombre_jours_conger'];
        $calculConger = $nombreCongerInitial - $nombreJoursConge;
        if($calculConger<0){
            return "Nombre de jous disponibles insuffisants";
        }else{
            $sql3 = $pdo->prepare("UPDATE nombreconger SET reste_conger = '$calculConger' WHERE id_users = ?");
            $sql3->execute([$idp]);
            return $calculConger;
        }
       
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

function verificationConger($pdo)
{
    try {
        if (!isset($_SESSION['id'])) {
            throw new Exception("Pas de users actifs");
        }
        $id = $_SESSION['id'];
        $date = date("Y-m-d");
        $sql = $pdo->prepare("
            SELECT *
            FROM conger
            JOIN users ON conger.id_users = users.id
            WHERE conger.id_users = ?
            AND date_fin_conger >= ?
        ");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute([$id, $date]);
        $result = $sql->fetchAll();
        return $result;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
function verificationResteConger($pdo)
{
    try {
        if (!isset($_SESSION['id'])) {
            throw new Exception("Pas de users actifs");
        }
        $id = $_SESSION['id'];
        $sql = $pdo->prepare("
            SELECT *
            FROM nombreconger
            JOIN users ON nombreconger.id_users = users.id
            WHERE nombreconger.id_users =?
        ");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute([$id]);
        $restConger = $sql->fetchAll();
        return $restConger;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

/**Gestion de presence */
function listePresence($pdo)
{
    try {
        $date = date("Y-m-d");
        $sql = $pdo->prepare("
            SELECT *
            FROM presence
            JOIN users ON presence.id_users = users.id
            WHERE date_pres =?
        ");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute([$date]);
        $listePresence = $sql->fetchAll();
        
        return $listePresence;
    }catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

function presenceEntrer($pdo)
{
    try {
        if (!isset($_SESSION["id"])) {
            throw new Exception("Pas de users actifs");
        }
        $id_pers = $_SESSION["id"];
        $date_pres = date("Y-m-d");
        $heure = date("H:i:s");
        $hereentre = '08:00:00';
        $dateActuelle = new DateTime($heure);
        $dateReference = new DateTime($hereentre);
        $interval = $dateActuelle->diff($dateReference);
        $minutes = ($interval->h * 60) + $interval->i + ($interval->s / 60);
        if($heure <= $hereentre){
            $motif = "ENTRE";
        } else{
            $motif = "RETARD en " . round($minutes)  . " minutes ";
        }
        $sql = $pdo->prepare("INSERT INTO presence (id_users, date_pres, observation, heure_entrer) VALUES (?, ?, ?, ?)");
        $sql->execute([$id_pers, $date_pres, $motif, $heure]);
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
function presenceSortie($pdo)
{
    try {
        if (!isset($_SESSION["id"])) {
            throw new Exception("Pas de users actifs");
        }
        $id_pers = $_SESSION["id"];
        $heure = date("H:i:s");
        $date_pres = date("Y-m-d");
        $sql = $pdo->prepare("UPDATE presence SET heure_sortie = ? WHERE id_users = ? AND date_pres = ?");
        $sql->execute([$heure, $id_pers, $date_pres]);
        return true;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
function verificationEntrer($pdo)
{
    try {
        if (!isset($_SESSION["id"])) {
            throw new Exception("Pas de users actifs");
        }
        $id_pers = $_SESSION["id"];
        $date_pres = date("Y-m-d");
        $sql = $pdo->prepare("SELECT * FROM presence WHERE id_users = ? AND date_pres = ?");
        $sql->execute([$id_pers, $date_pres]);
        $presence = $sql->fetch(PDO::FETCH_ASSOC);
        if ($presence && $presence["heure_entrer"] !== '00:00:00') {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
function verificationSortie($pdo)
{
    try {
        if (!isset($_SESSION["id"])) {
            throw new Exception("Pas de users actifs");
        }
        $id_users = $_SESSION["id"];
        $date_pres = date("Y-m-d");
        $sql = $pdo->prepare("SELECT * FROM presence WHERE id_users = ? AND date_pres = ?");
        $sql->execute([$id_users, $date_pres]);
        $presence = $sql->fetch(PDO::FETCH_ASSOC);
        if ($presence && $presence["heure_sortie"] !== '00:00:00') {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
