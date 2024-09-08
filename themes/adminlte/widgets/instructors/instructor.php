<?php $this->layout("_admin"); ?>

<section class="dash_content_app">
    <?php if (!$form["data"]): ?>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= (!empty($form["data"])) ? $form["data"]->fullName() : "Cadastrar Instrutor"; ?></h3>
            </div>
            <?= $this->insert("inc/students"); ?>
        </div>
    <?php else: ?>
        <!-- Main content -->
<section class="content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <?php
                            $userPhoto = ($user->photo() ? image($user->photo, 300, 300) :
                            theme("/assets/images/avatar.jpg", CONF_VIEW_ADMIN));
                        ?>
                        <img class="profile-user-img img-fluid img-circle"
                            src="<?= $userPhoto ?>"
                            alt="<?= $user->fullName() ?>">
                    </div>

                    <h3 class="profile-username text-center"><?= $user->fullName() ?></h3>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                        <b>Alunos Ativo</b> <a class="float-right"><?= $user->student()["activated"] ?></a>
                        </li>
                        <li class="list-group-item">
                        <b>Alunos Desativados</b> <a class="float-right"><?= $user->student()["deactivated"] ?></a>
                        </li>
                        <li class="list-group-item">
                        <b>Alunos Pendente</b> <a class="float-right"><?= $user->student()["pending"] ?></a>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#black" data-toggle="tab">Faixa Pretas</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kyus" data-toggle="tab">Kyus</a></li>
                    <li class="nav-item"><a class="nav-link" href="#profile" data-toggle="tab">Perfil</a></li>
                </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="black">
                        <?php if(!empty($blacks)): ?>
                            <?php foreach($blacks as $black):                             
                                $userPhoto = ($black->photo() ? image($black->photo, 300, 300) :
                                theme("/assets/images/avatar.jpg", CONF_VIEW_ADMIN));
                            ?>
                                <div class="post">
                                    <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="<?= $userPhoto ?>" alt="<?= $black->fullName() ?>">
                                    <span class="username">
                                        <a href="<?= url("admin/students/black/student/{$black->id}") ?>"><?= $black->fullName() ?></a>
                                    </span>
                                    <span class="description">Cadastrado em - <?= date_fmt($black->created_at, "d/m/y \à\s H\hi"); ?></span>
                                    <span class="description">Faixa - <strong class="badge" style="background-color: <?= $black->belt()->color ?>"><?= $black->belt()->title ?></strong> | Status - <strong class="badge bg-<?= ($black->status == 'activated') ? 'success': (($black->status == 'pending') ? 'warning' : 'danger') ?>"><?= ($black->status == 'activated') ? 'Ativo': (($black->status == 'pending') ? 'Pendente' : 'Desativado') ?></strong></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-info alert-dismissible">
                                <h5><i class="icon fas fa-info"></i> Aviso!</h5>
                                Nenhum faixa preta desse professor foi encontrado! 
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="kyus">
                        <?php if(!empty($kyus)): ?>
                            <?php foreach($kyus as $kyu):                             
                                $userPhoto = ($kyu->photo() ? image($kyu->photo, 300, 300) :
                                theme("/assets/images/avatar.jpg", CONF_VIEW_ADMIN));
                            ?>
                                <div class="post">
                                    <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="<?= $userPhoto ?>" alt="<?= $kyu->fullName() ?>">
                                    <span class="username">
                                        <a href="<?= url("admin/students/kyus/student/{$kyu->id}") ?>"><?= $kyu->fullName() ?></a>
                                    </span>
                                    <span class="description">Cadastrado em - <?= date_fmt($kyu->created_at, "d/m/y \à\s H\hi"); ?></span>
                                    <span class="description">Faixa - <strong class="badge" style="background-color: <?= $kyu->belt()->color ?>"><?= $kyu->belt()->title ?></strong> | Status - <strong class="badge bg-<?= ($kyu->status == 'activated') ? 'success': (($kyu->status == 'pending') ? 'warning' : 'danger') ?>"><?= ($kyu->status == 'activated') ? 'Ativo': (($kyu->status == 'pending') ? 'Pendente' : 'Desativado') ?></strong></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-info alert-dismissible">
                                <h5><i class="icon fas fa-info"></i> Aviso!</h5>
                                Nenhum kyus desse professor foi encontrado! 
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="tab-pane" id="profile">
                        <?= $this->insert("inc/students"); ?>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
    <?php endif; ?>
</section>