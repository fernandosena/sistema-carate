<?php $this->layout("_admin"); ?>

<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
            <h3><?= $quantity["teachers"] ?></h3>
                <p>Instrutores</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="<?= url("admin/instructors/home") ?>" class="small-box-footer">Ver todos <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $quantity["black"] ?></h3>
                <p>Dan</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="<?= url("admin/students/black/home") ?>" class="small-box-footer">Ver todos <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
        <div class="inner">
            <h3><?= $quantity["kyus"] ?></h3>
            <p>Kyus</p>
        </div>
        <div class="icon">
            <i class="ion ion-person"></i>
        </div>
        <a href="<?= url("admin/students/kyus/home") ?>" class="small-box-footer">Ver todos <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
        <div class="inner">
            <h3><?= $quantity["belts"] ?></h3>
            <p>Graduações</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="<?= url("admin/belts/home") ?>" class="small-box-footer">Ver todos <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<div class="row">
    <div class="div col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ion ion-clipboard mr-1"></i> Avisos
                </h3>
            </div>

            <div class="card-body">
                <?php if(!empty($info["instructors"]) || !empty($info["black"])): ?>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Data da graduação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($info["instructors"])): ?>
                                <?php foreach ($info["instructors"] as $instructors): ?>
                                <tr>
                                    <td><a href="<?= url("/admin/instructors/instructor/{$instructors->id}"); ?>"><?= $instructors->fullName(); ?></a></td>
                                    <td><?= date_fmt($instructors->next_graduation, "d/m/Y"); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php if(!empty($info["black"])): ?>
                                <?php foreach ($info["black"] as $black):?>
                                <tr>
                                    <td><a href="<?= url("/admin/students/black/student/{$black->id}"); ?>"><?= $black->fullName(); ?></a></td>
                                    <td><?= date_fmt($black->next_graduation, "d/m/Y"); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Data da graduação</th>
                            </tr>
                        </tfoot>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info alert-dismissible">
                        <h5><i class="icon fas fa-info"></i> Alerta!</h5>
                        Nenhum aviso encontrado
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>