<?php $this->layout("_admin"); ?>

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
                    <li class="nav-item"><a class="nav-link active" href="#students" data-toggle="tab">Alunos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#profile" data-toggle="tab">Perfil</a></li>
                </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="students">
                        <?php if(!empty($students)): ?>
                            <?php foreach($students as $student):                             
                                $userPhoto = ($user->photo() ? image($user->photo, 300, 300) :
                                theme("/assets/images/avatar.jpg", CONF_VIEW_ADMIN));
                            ?>
                                <div class="post">
                                    <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="<?= $userPhoto ?>" alt="<?= $student->fullName() ?>">
                                    <span class="username">
                                        <a href="#"><?= $student->fullName() ?></a>
                                    </span>
                                    <span class="description">Cadastrado em - <?= date_fmt($student->created_at, "d/m/y \à\s H\hi"); ?></span>
                                    <span class="description">Faixa - <strong class="badge texto-adaptavel" style="background-color: <?= $student->belt()->color ?>"><?= $student->belt()->title ?></strong> | Status - <strong class="badge bg-<?= ($student->status == 'activated') ? 'success': (($student->status == 'pending') ? 'warning' : 'danger') ?>"><?= ($student->status == 'activated') ? 'Ativo': (($student->status == 'pending') ? 'Pendente' : 'Desativado') ?></strong></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-info alert-dismissible">
                                <h5><i class="icon fas fa-info"></i> Aviso!</h5>
                                Nenhum aluno desse professor foi encontrado! 
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="profile">
                    <form class="form-horizontal">
                        <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        </div>
                        <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                        </div>
                        </div>
                        <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputName2" placeholder="Name">
                        </div>
                        </div>
                        <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                        </div>
                        </div>
                        <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                        </div>
                        </div>
                        <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                            <div class="checkbox">
                            <label>
                                <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                            </label>
                            </div>
                        </div>
                        </div>
                        <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
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