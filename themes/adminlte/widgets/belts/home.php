<?php $this->layout("_admin"); ?>
<?php if($belts): ?>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lista de instrutores</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
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
                                            <td><?= $belt->title; ?></td>
                                            <td><?= $belt->student()["all"] ?></td>
                                            <td><a href="<?= url("/admin/belts/belt/{$belt->id}"); ?>" class="btn btn-primary btn-block"><b>Gerênciar</b></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Titulo</th>
                                        <th>Qtd. de alunos</th>
                                        <th>Opções</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php else: ?>
    <div class="alert alert-info alert-dismissible">
        <h5><i class="icon fas fa-info"></i> Informação!</h5>
        Nenhuma Graduação Cadastrada
    </div>
<?php endif; ?>