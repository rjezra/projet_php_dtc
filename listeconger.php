<?php
$lien = "conger";
require_once('./dashboard.php');

?>
<div class="container">
    <section>
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-lg-7 col-xl-7">
                <h2>Liste des congés</h2>
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Photo</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Nombre de jous de conger</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($listCongers) && !empty($listCongers)) { ?>
                            <?php foreach ($listCongers as $conger) { ?>
                                <tr class="table-active">
                                    <th scope="row"><img src="./assests/img/<?= htmlspecialchars($conger["photo"]) ?>" alt="" class="profil"></th>
                                    <td><?= htmlspecialchars($conger['nom']) ?></td>
                                    <td><?= htmlspecialchars($conger['prenom']) ?></td>
                                    <td><?= htmlspecialchars($conger['nombre_jours_conger']) ?></td>
                                    <td>
                                        <div class="action">
                                            <form method="post" action="">
                                                <input type="hidden" name="id_supprimer" value="<?= htmlspecialchars($conger['id_conger']) ?>">
                                                <button class="btn btn-primary rounded-pill px-3" type="submit" name="afficherconger">Afficger</button>
                                                <input type="hidden" name="id_afficherconger" value="<?= htmlspecialchars($conger['id_conger']) ?>">
                                                <input type="hidden" name="id_valider" value="<?= htmlspecialchars($conger['id_conger']) ?>">
                                                <input type="hidden" name="id_users" value="<?= htmlspecialchars($conger['id']) ?>">
                                                <?php if ($conger['acceptation_conger'] == "Accepter") { ?>
                                                        <div class="btn btn-success  rounded-pill px-1">Accepter</div>
                                                <?php } else if ($conger['acceptation_conger'] == "Reffuser") { ?>
                                                    <div class="btn btn-danger rounded-pill px-1">Reffuser</div>
                                                <?php } else { ?>
                                                    <button class="btn btn-success rounded-pill px-1" type="submit" name="congerValider">Valider</button>
                                                    <button class="btn btn-danger rounded-pill px-1" type="submit" name="reffuserValider">Reffuser</button>
                                                <?php } ?>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="6">Aucun congé trouvé.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-10 col-lg-6 col-xl-4 offset-xl-1 alert alert-info ml-1" style="margin-left: 1%;">
                <h2>Informations personnelles</h2>
                
               
                <?php if (isset($result) && !empty($result)) { ?>
                    <div class="photo">
                        <img src="./assests/img/<?= htmlspecialchars($result[0]["photo"]) ?>" alt="" class="profil">
                    </div>
                    <div class="info">
                        <div class="card-header">
                            <h5><strong>Nom:</strong> <?= htmlspecialchars($result[0]['nom']) ?></h5>
                        </div>
                        <div class="card-header">
                            <h5><strong>Prénom:</strong> <?= htmlspecialchars($result[0]['prenom']) ?></h5>
                        </div>
                        <div class="card-header">
                            <h5><strong>Rôles:</strong> <?= htmlspecialchars($result[0]['roles']) ?></h5>
                        </div>  
                        <div class="card-header">
                            <h5><strong>Date de début du congé:</strong> <?= htmlspecialchars($result[0]['date_debut_conger']) ?></h5>
                        </div>
                        <div class="card-header">
                            <h5><strong>Date de fin du congé:</strong> <?= htmlspecialchars($result[0]['date_fin_conger']) ?></h5>
                        </div>
                        <div class="card-header">
                            <?php if ($result[0]['acceptation_conger'] == "Accepter") { ?>
                                <div class="alert alert-success">Validation de conger est Valide </div>
                                <?php } else if ($result[0]['acceptation_conger'] == "Reffuser") { ?>
                                    <div class="alert alert-danger">Validation de conger est Reffuser </div>
                            <?php } else { ?>
                                <div class="alert alert-danger">Votre Conger est en attente</div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } else { ?>
                    <div>Aucune information disponible.</div>
                <?php } ?>
            </div>
        </div>
    </section>
</div>

<?php require_once('./elements/footer.php'); ?>
