<?php if ($result) : ?>
<div class="col-6 mb-3">
    <h6>Etat de conger</h6>
    <div class="alert alert-success"><?= $result[0]['acceptation_conger'] ?></div>
</div>
<div class="col-6 mb-3">
    <h6>NOmbre de conger</h6>
    <div class="alert alert-success"><?= $result[0]['nombre_jours_conger'] ?></div>
</div>
<?php else : ?>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
        Demande conger
    </button>
<?php endif ?>

<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">DEMANDE CONGER</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Debut de conger</label>
                        <input type="date" name="dateDebut" class="form-control" id="exampleFormControlInput1" placeholder="Entre votre nom">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Fin de conger</label>
                        <input type="date" name="dateFin" class="form-control" id="exampleFormControlInput1" placeholder="Entre votre nom">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Motif de conger</label>
                        <input type="text" name="motif" class="form-control" id="exampleFormControlInput1" placeholder="Entre votre nom">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" name="conger">Envoyer</button>
                </div>
            </form>

        </div>
    </div>
</div>