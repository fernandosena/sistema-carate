<?php $this->layout("_admin"); ?>
<?php if($belts): ?>
    <div class="list-box">
        <?php foreach ($belts as $belt): ?>
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <h3 class="m-auto d-block profile-username badge text-center"><?= $belt->title; ?></h3>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Qtd. de alunos</b> <a class="float-right"><?= $belt->student()["activated"] ?></a>
                        </li>
                    </ul>
                    <a href="<?= url("/admin/belts/belt/{$belt->id}"); ?>" class="btn btn-primary btn-block"><b>Gerênciar</b></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?= $paginator; ?>
<?php else: ?>
    <div class="alert alert-info alert-dismissible">
        <h5><i class="icon fas fa-info"></i> Informação!</h5>
        Nenhuma Graduação Cadastrada
    </div>
<?php endif; ?>