<?php $this->layout("_admin"); ?>

<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $students["dan"]["count"] ?></h3>
                <p>Dan</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="<?= url("admin/students/{$user->id}/black/home/all") ?>" class="small-box-footer">Ver todos <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
        <div class="inner">
            <h3><?= $students["kyu1"]["count"] ?></h3>
            <p>Kyus até 12 anos</p>
        </div>
        <div class="icon">
            <i class="ion ion-person"></i>
        </div>
        <a href="<?= url("admin/students/{$user->id}/kyus/home/menor") ?>" class="small-box-footer">Ver todos <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
        <div class="inner">
            <h3><?= $students["kyu2"]["count"] ?></h3>
            <p>Kyus a partir de 13 anos</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="<?= url("admin/students/{$user->id}/kyus/home/maior") ?>" class="small-box-footer">Ver todos <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= ($user->first_name) ? str_limit_chars($user->first_name, 15): "Instrutor" ?></h3>
                <p>Perfil</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="<?= url("admin/instructors/instructor/{$user->id}/profile") ?>" class="small-box-footer">Editar <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<div class="row">
    <div class="div col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ion ion-clipboard mr-1"></i> Todos os Pagamentos o instrutor
                </h3>
            </div>

            <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Valor</th>
                        <th>Qtd. Alunos</th>
                        <th>Cadastro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment): ?>
                    <tr>
                        <td>R$ <?= number_format($payment->value, 2, ',', '.') ?></td>
                        <td><?= $payment->qtd_alunos ?></td>
                        <td><?= date("d/m/Y H:m:s", strtotime($payment->created_at)) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Valor</th>
                        <th>Qtd. Alunos</th>
                        <th>Cadastro</th>
                    </tr>
                </tfoot>
            </table>
            </div>
        </div>
    </div>
</div>