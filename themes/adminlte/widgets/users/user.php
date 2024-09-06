<?php $this->layout("_admin"); ?>

<section class="dash_content_app">
    <?php if (!$user): ?>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= (!empty($user)) ? $user->fullName() : "Criar novo usuário"; ?></h3>
            </div>
            <form class="app_form" action="<?= url("/admin/users/user/{$user->id}"); ?>" method="post">
                <div class="card-body">
                    <!--ACTION SPOOFING-->
                    <input type="hidden" name="action" value="create"/>
                    <input type="hidden" name="level" value="1" required>
                    <input type="hidden" name="status" value="confirmed" required>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Nome</label>
                                <input type="text"
                                name="first_name"  class="form-control" placeholder="Primeiro nome" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Sobrenome:</label>
                                <input type="text"
                                name="last_name" class="form-control" placeholder="Último nome" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Genero</label>
                                <select class="form-control"  name="genre">
                                    <option value="male">Masculino</option>
                                    <option value="female">Feminino</option>
                                    <option value="other">Outros</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="exampleInputFile">Foto: (600x600px)</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile" name="photo">
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nascimento</label>
                                <input type="date"
                                name="datebirth" class="form-control" placeholder="dd/mm/yyyy">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>CPF</label>
                                <input type="text"
                                name="document" class="form-control mask-doc" placeholder="CPF do usuário">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*E-mail</label>
                                <input type="email"
                                name="email" class="form-control" placeholder="Melhor e-mail" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Senha</label>
                                <input type="password"
                                name="password" class="form-control mask-doc" placeholder="Senha de acesso" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Criar Usuário</button>
                </div>
            </form>
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
                    <form class="app_form" action="<?= url("/admin/users/user/{$user->id}"); ?>" method="post">
                        <div class="card-body">
                            <!--ACTION SPOOFING-->
                            <input type="hidden" name="action" value="update"/>
                            <input type="hidden" name="level" value="1">
                            <input type="hidden" name="status" value="confirmed">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>*Nome</label>
                                        <input type="text"
                                        name="first_name" value="<?= $user->first_name; ?>" class="form-control" placeholder="Primeiro nome" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>*Sobrenome:</label>
                                        <input type="text"
                                        name="last_name" value="<?= $user->last_name; ?>" class="form-control" placeholder="Último nome" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Genero</label>
                                        <?php
                                            $genre = $user->genre;
                                            $select = function ($value) use ($genre) {
                                                return ($genre == $value ? "selected" : "");
                                            };
                                        ?>
                                        <select class="form-control" name="genre">
                                            <option <?= $select("male"); ?> value="male">Masculino</option>
                                            <option <?= $select("female"); ?> value="female">Feminino</option>
                                            <option <?= $select("other"); ?>  value="other">Outros</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Foto: (600x600px)</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                            <input type="file" name="photo" class="custom-file-input" id="exampleInputFile">
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
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nascimento</label>
                                        <input type="date"
                                        name="datebirth" value="<?= (!empty($user->datebirth)) ? date_fmt($user->datebirth, "Y-m-d") : null; ?>" class="form-control" placeholder="dd/mm/yyyy">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>CPF</label>
                                        <input type="text"
                                        name="document" class="form-control mask-doc" value="<?= $user->document; ?>" placeholder="CPF do usuário">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>*E-mail</label>
                                        <input type="email"
                                        name="email" value="<?= $user->email; ?>"  class="form-control" placeholder="Melhor e-mail" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Senha</label>
                                        <input type="password"
                                        name="password" class="form-control mask-doc" placeholder="Senha de acesso">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Atualizar Perfil</button>
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