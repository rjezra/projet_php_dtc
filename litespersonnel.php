<?php
$lien = "liste";
 require_once('./dashboard.php');
?>
<div class="container">

    <section>
        <div class="row d-flex justify-content-center  ">
            <div class="col-md-10 col-lg-7 col-xl-5">
                <h2>Listes des utilisateurs</h2>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Photo</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prenom</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultusers as $resultuser) { ?>
                            <tr class="table-active">
                                <th scope="row"><img src="./assests/img/<?= htmlentities($resultuser["photo"] )?>" alt="" class="profil"></th>
                                <td><?= htmlentities($resultuser["nom"]) ?></td>
                                <td><?= htmlentities($resultuser["prenom"]) ?></td>
                                <td>
                                    <div class="action">
                                        <form method="post" action="">
                                            <input type="hidden" name="id_supprimer" value="<?= $resultuser["id"] ?>">
                                            <button type="submit" name="afficher"><i class="bi bi-cast"></i></button>
                                            <input type="hidden" name="id_afficher" value="<?= $resultuser["id"] ?>">
                                            <button type="submit" name="supprimer"><i class="bi bi-trash3" alt="suppression"></i></button>
                                            <input type="hidden" name="id_edit" value="<?= $resultuser["id"] ?>">
                                            <button type="submit" name="edit"><i class="bi bi-pencil-square"></i></button>
                                            <input type="hidden" name="id_valider" value="<?= $resultuser["id"] ?>">
                                            <button type="submit" name="valider">
                                                <?php if ($resultuser["isEnable"] == true) { ?>
                                                    <i class="bi bi-check-circle-fill"></i>
                                                <?php } else { ?>
                                                    <i class="bi bi-check-circle"> </i>
                                                <?php } ?>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-10 col-lg-6 col-xl-4 offset-xl-1 alert alert-info ml-1">
                <h2>Information personnel</h2>
                <?php if ($results != null) { ?>
                    <div class="photo">
                        <img src="./assests/img/<?= htmlentities($results["photo"]) ?>" alt="" class="profil">
                    </div>
                    <div class="info">
                        <div class="card-header">
                            <h3> <strong>Nom:</strong> <?= htmlentities($results["nom"]) ?></h3>
                        </div>
                        <div class="card-header">
                            <h3><strong>Prenom: </strong><?= htmlentities($results["prenom"]) ?></h3>
                        </div>
                        <div class="card-header">
                            <h3><strong>Roles: </strong><?= htmlentities($results["roles"]) ?></h3>
                        </div>
                        <div class="card-header">
                            <?php if ($results["isEnable"]  == true) { ?>
                                <div class="alert alert-success">Votre login est activer</div>
                            <?php } else { ?>
                                <div class="alert alert-danger">Votre login mis en antentte</div>
                            <?php } ?>
                        </div>
                    </div>
                <?php
                } else {
                    echo "Aucune information disponible.";
                }
                ?>
            </div>
        </div>
    </section>
</div>
<?php require_once('./elements/footer.php');?>
