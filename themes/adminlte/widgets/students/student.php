<?php $this->layout("_admin"); ?>

<section class="dash_content_app">
    <?php if (!$form["data"]): ?>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Cadastrar Aluno</h3>
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
                                    $userPhoto = ($form["data"]->photo() ? image($form["data"]->photo, 300, 300) :
                                    theme("/assets/images/avatar.jpg", CONF_VIEW_ADMIN));
                                ?>
                                <img class="profile-user-img img-fluid img-circle"
                                    src="<?= $userPhoto ?>"
                                    alt="<?= $form["data"]->fullName() ?>">
                            </div>

                            <h3 class="profile-username text-center"><?= $form["data"]->fullName() ?></h3>

                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#students" data-toggle="tab">Detalhes</a></li>
                            <li class="nav-item"><a class="nav-link" href="#profile" data-toggle="tab">Perfil</a></li>
                        </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="students">
                                <ul class="timeline">
                                    <?php $c=0; foreach($form["data"]->historic() as $historic):?>
                                        <?php  if($historic->status == "approved" && $c == 0){$c = 1;} ?>
                                        <li <?= ($c == 1) ? 'class="active"': null?>>
                                            <h6><?= $historic->findBelt($historic->graduation_id)->title ?><?= ($historic->status == "pending") ? " - <span class='badge bg-warning'>Em Análise</span>" : (($historic->status == "disapprove") ? " - <span class='badge bg-danger'>Reprovado</span>" : null) ; ?></h6>
                                            <o class="text-muted"><?= date_fmt($historic->graduation_data, "d/m/y"); ?></p>

                                            <?php if($historic->status == "pending"): ?>
                                                <a href="#" class="btn bg-success"
                                                data-post="<?= $form["url"] ?>"
                                                data-action="update_graduation"
                                                data-type_action="approved"
                                                data-confirm="ATENÇÃO: Tem certeza que deseja APROVAR essa o graduação?"
                                                data-historic_id="<?= $historic->id; ?>"><i class="fa-solid fa-circle-check"></i> Aprovar</a>

                                                <a href="#" class="btn bg-danger"
                                                data-post="<?= $form["url"] ?>"
                                                data-action="update_graduation"
                                                data-type_action="disapprove"
                                                data-confirm="ATENÇÃO: Tem certeza que deseja REPROVAR essa o graduação?"
                                                data-historic_id="<?= $historic->id; ?>"><i class="fa-sharp fa-solid fa-xmark"></i> Reprovar</a>
                                            <?php else: ?>
                                                <a href="#" class="p-1 rounded bg-danger"
                                                data-post="<?= $form["url"] ?>"
                                                data-action="delete_graduation"
                                                data-confirm="ATENÇÃO: Tem certeza que deseja DELETAR essa raduação?"
                                                data-historic_id="<?= $historic->id; ?>"><i class="fa-sharp fa-solid fa-trash"></i> Deletar</a>
                                            <?php endif; ?>
                                        </li>
                                    <?php 
                                        if($c == 1){$c = 2;}
                                        endforeach; ?>
                                </ul>
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