<?php $this->layout("_admin"); ?>

<section class="dash_content_app">
    <?php if (!$student): ?>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Cadastrar Aluno</h3>
            </div>
            <form class="app_form" action="<?= url("/admin/users/user/{$student->id}"); ?>" method="post">
                <div class="card-body">
                    <!--ACTION SPOOFING-->
                    <input type="hidden" name="action" value="update"/>
                    <div class="row">
                        <div class="col-sm-12">
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
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>*Professor</label>
                                <select class="form-control" name="genre">
                                    <?php 
                                        foreach($teachers as $teacher):    
                                    ?>
                                    <option value="<?= $teacher->id ?>"><?= $teacher->FullName() ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Nome</label>
                                <input type="text"
                                name="first_name" class="form-control" placeholder="Primeiro nome" required>
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
                                <select class="form-control" name="genre">
                                    <option value="male">Masculino</option>
                                    <option value="female">Feminino</option>
                                    <option value="other">Outros</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Telefone</label>
                                <input type="tel"
                                name="phone" class="form-control mask-phone" placeholder="">
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
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>*E-mail</label>
                                <input type="email"
                                name="email"  class="form-control" placeholder="Melhor e-mail" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Descrição</label>
                                <textarea
                                name="description"  class="form-control" placeholder="Descrição do aluno"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Faixa</label>
                                <select class="form-control" name="status" required>
                                    <?php 
                                        foreach($belts as $belt):    
                                    ?>
                                    <option value="<?= $belt->id ?>"><?= $belt->title ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Status</label>
                                <select class="form-control" name="status" required>
                                    <option value="activated">Ativo</option>
                                    <option value="deactivated">Desativado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Cadastrar Aluno</button>
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
                                    $userPhoto = ($student->photo() ? image($student->photo, 300, 300) :
                                    theme("/assets/images/avatar.jpg", CONF_VIEW_ADMIN));
                                ?>
                                <img class="profile-user-img img-fluid img-circle"
                                    src="<?= $userPhoto ?>"
                                    alt="<?= $student->fullName() ?>">
                            </div>

                            <h3 class="profile-username text-center"><?= $student->fullName() ?></h3>

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
                                    <?php $c=0; foreach($student->historic() as $historic):?>
                                        <li <?= ($c == 0) ? 'class="active"': null?>>
                                            <h6><?= $historic->findBelt($historic->belt_id)->title ?></h6>
                                            <p class="mb-0 text-muted"><?= $historic->description ?></p>
                                            <o class="text-muted"><?= date_fmt($historic->created_at, "d/m/y \à\s H\hi"); ?></p>
                                        </li>
                                    <?php $c++;endforeach; ?>
                                </ul>
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
    <?php endif; ?>
</section>