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
                                        <th>Idade</th>
                                        <th>Posição na graduação</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($belts as $belt): ?>
                                        <tr>
                                            <td><?= $belt->title; ?></td>
                                            <td><?php
                                                if($belt->age_range == 1){
                                                    echo "Até 12 anos";
                                                }elseif($belt->age_range == 2){
                                                    echo "A partir de 13 anos";
                                                }else{
                                                    echo "Todos";
                                                }
                                            ?></td>
                                            <td><?= $belt->position; ?></td>
                                            <td><a href="<?= url("/admin/belts/belt/{$belt->id}"); ?>" class="btn btn-primary btn-block"><b>Gerênciar</b></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Titulo</th>
                                        <th>Idade</th>
                                        <th>Posição na graduação</th>
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