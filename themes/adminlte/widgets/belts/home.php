<?php $this->layout("_admin"); ?>
<?php if($belts): ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Bordered Table</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Titulo</th>
                        <th>Qtd. de alunos</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($belts as $belt): ?>
                        <tr>
                            <td><h3 class="m-auto d-block profile-username badge text-center"><?= $belt->title; ?></h3></td>
                            <td><?= $belt->student()["all"] ?></td>
                            <td><a href="<?= url("/admin/belts/belt/{$belt->id}"); ?>" class="btn btn-primary btn-block"><b>Gerênciar</b></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            <?= $paginator; ?>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info alert-dismissible">
        <h5><i class="icon fas fa-info"></i> Informação!</h5>
        Nenhuma Graduação Cadastrada
    </div>
<?php endif; ?>