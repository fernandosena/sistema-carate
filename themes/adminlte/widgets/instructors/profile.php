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
                            $userPhoto = ""
                        ?>
                        <img class="profile-user-img img-fluid img-circle"
                            src="<?= $userPhoto ?>"
                            alt="<?= $user->fullName() ?>">
                    </div>

                    <h3 class="profile-username text-center"><?= $user->fullName() ?></h3>
                    <?php if($user->level != 5): ?>
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
                    <?php endif; ?>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <?php if($user->level == 5): ?>
                        <li class="nav-item"><a class="nav-link" href="#system" data-toggle="tab">Sistema</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link <?php if($user->level != 5): ?>active<?php endif; ?>" href="#profile" data-toggle="tab">Perfil</a></li>
                </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                <div class="tab-content">
                    <div class="<?php if($user->level != 5): ?>active<?php endif; ?> tab-pane" id="profile">
                        <?= $this->insert("inc/students"); ?>
                    </div>
                    <div class="tab-pane" id="system">
                    <form class="app_form" enctype="multipart/form-data" action="<?= url("admin/conf") ?>" method="post">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Logo: (600x600px)</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                            <input type="file" accept="image/png, image/jpeg" class="custom-file-input" id="exampleInputFile" name="photo">
                                            <label class="custom-file-label" for="exampleInputFile">Escolher imagens</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>*Titulo</label>
                                        <input type="text"
                                        name="title" value="<?= conf()->title ?? null ?>" class="form-control" placeholder="Titulo" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>*Preço por aluno</label>
                                        <input type="text"
                                        name="price" value="<?= conf()->price ?? 0 ?>" class="form-control mask-money" placeholder="Preço por aluno" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </div>
                    </form>
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