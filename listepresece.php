<?php
$lien = "presence";
require_once('./dashboard.php');
?>
<div class="container">

    <section>
        <div class="row d-flex justify-content-center  ">
            <h2>Listes des utilisateurs</h2>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Photo</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prenom</th>
                        <th scope="col">Heure d'entre</th>
                        <th scope="col">Heure de sortie</th>
                        <th scope="col">Observation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listePresences as $listePresence) { ?>
                        <tr class="table-active">
                            <th scope="row"><img src="./assests/img/<?= htmlentities($listePresence['photo'])?>" alt="" class="profil"></th>
                            <td><?= htmlentities($listePresence['nom'])?></td>
                            <td><?= htmlentities($listePresence['prenom']) ?></td>
                            <td><?=htmlentities($listePresence['heure_entrer']) ?></td>
                            <td><?=htmlentities($listePresence['heure_sortie'])?></td>
                            <td><?=htmlentities($listePresence['observation'])?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
<?php require_once('./elements/footer.php'); ?>