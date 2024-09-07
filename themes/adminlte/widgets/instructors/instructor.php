<?php $this->layout("_admin"); ?>

<section class="dash_content_app">
    <?php if (!$user): ?>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= (!empty($user)) ? $user->fullName() : "Cadastrar Instrutor"; ?></h3>
            </div>
            <form class="app_form" id="address-form" action="<?= url("/admin/instructors/instructor"); ?>" method="post">
                <div class="card-body">
                    <!--ACTION SPOOFING-->
                    <input type="hidden" name="action" value="create"/>
                    <input type="hidden" name="level" value="1" required>
                    <input type="hidden" name="status" value="confirmed" required>
                    <div class="row">
                        <div class="col-sm-12">
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
                                <label>*CPF</label>
                                <input type="text"
                                name="document" class="form-control mask-doc" placeholder="CPF do usuário" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>* Nascimento</label>
                                <input type="date"
                                name="datebirth" class="form-control" placeholder="dd/mm/yyyy" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*CEP</label>
                                <input id="cep" type="text"
                                name="zip" class="form-control" placeholder="CEP" required maxlength="8" minlength="8">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Estado</label>
                                <select class="form-control" name="state" id="state" disabled required data-input>
                                    <option selected>Estado</option>
                                    <option value="AC">Acre</option>
                                    <option value="AL">Alagoas</option>
                                    <option value="AP">Amapá</option>
                                    <option value="AM">Amazonas</option>
                                    <option value="BA">Bahia</option>
                                    <option value="CE">Ceará</option>
                                    <option value="DF">Distrito Federal</option>
                                    <option value="ES">Espírito Santo</option>
                                    <option value="GO">Goiás</option>
                                    <option value="MA">Maranhão</option>
                                    <option value="MT">Mato Grosso</option>
                                    <option value="MS">Mato Grosso do Sul</option>
                                    <option value="MG">Minas Gerais</option>
                                    <option value="PA">Pará</option>
                                    <option value="PB">Paraíba</option>
                                    <option value="PR">Paraná</option>
                                    <option value="PE">Pernambuco</option>
                                    <option value="PI">Piauí</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="RN">Rio Grande do Norte</option>
                                    <option value="RS">Rio Grande do Sul</option>
                                    <option value="RO">Rondônia</option>
                                    <option value="RR">Roraima</option>
                                    <option value="SC">Santa Catarina</option>
                                    <option value="SP">São Paulo</option>
                                    <option value="SE">Sergipe</option>
                                    <option value="TO">Tocantins</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Cidade</label>
                                <input id="city" type="text"
                                name="city" class="form-control" placeholder="Cidade" disabled required data-input>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Endereço</label>
                                <input id="address" type="text"
                                name="address" class="form-control" placeholder="Endereço" disabled required data-input>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Bairro</label>
                                <input type="text"
                                name="neighborhood" id="neighborhood" class="form-control" placeholder="Complemento" disabled required data-input>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Nº</label>
                                <input type="text"
                                name="number" class="form-control" placeholder="Nº" disabled required data-input>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Complemento</label>
                                <input type="text"
                                name="complement" class="form-control" placeholder="Complemento" disabled data-input>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Celular</label>
                                <input type="text"
                                name="phone" class="form-control mask-phone" placeholder="Celular" required>
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
                                <div class="input-group mb-3">
                                    <input type="text" name="password" id="password" class="form-control" placeholder="Senha de acesso" required>
                                    <div class="input-group-append">
                                        <span class="btn input-group-text" onclick="getPassword()" id="btn">Gerar Senha</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Graduação</label>
                                <?php
                                    $graduation = $user->graduation;
                                    $select = function ($value) use ($graduation) {
                                        return ($graduation == $value ? "selected" : "");
                                    };
                                ?>
                                <select class="form-control" name="graduation">
                                    <?php foreach($graduations as $graduation): ?>
                                        <option <?= $select($graduation->id); ?> value="<?= $graduation->id ?>"><?= $graduation->title ?></option>
                                    <?php endforeach;   ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Dojo</label>
                                <select name="dojo[]" class="form-control" id="pieces" multiple></select>
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
                                        <a href="<?= url("admin/students/student/{$student->id}") ?>"><?= $student->fullName() ?></a>
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
                    <form class="app_form" id="address-form" action="<?= url("/admin/instructors/instructor/{$user->id}"); ?>" method="post">
                        <div class="card-body">
                            <!--ACTION SPOOFING-->
                            <input type="hidden" name="action" value="update"/>
                            <input type="hidden" name="level" value="1">
                            <input type="hidden" name="status" value="confirmed">
                            
                            <div class="row">
                                <div class="col-sm-12">
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
                                        <label>*CPF</label>
                                        <input type="text"
                                        name="document" value="<?= $user->document; ?>" class="form-control mask-doc" placeholder="CPF do usuário" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nascimento</label>
                                        <input type="date"
                                        name="datebirth" value="<?= (!empty($user->datebirth)) ? date_fmt($user->datebirth, "Y-m-d") : null; ?>" class="form-control" placeholder="dd/mm/yyyy">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>CEP</label>
                                        <input type="text" id="cep" type="text"
                                        name="zip" class="form-control" value="<?= $user->zip; ?>" placeholder="CEP">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>*Estado</label>
                                        <?php
                                            $state = $user->state;
                                            $select = function ($value) use ($state) {
                                                return ($state == $value ? "selected" : "");
                                            };
                                        ?>
                                        <select class="form-control" name="state" id="state" required data-input>
                                            <option selected>Estado</option>
                                            <option <?= $select("AC")?> value="AC">Acre</option>
                                            <option <?= $select("AL")?> value="AL">Alagoas</option>
                                            <option <?= $select("AP")?> value="AP">Amapá</option>
                                            <option <?= $select("AM")?> value="AM">Amazonas</option>
                                            <option <?= $select("BA")?> value="BA">Bahia</option>
                                            <option <?= $select("CE")?> value="CE">Ceará</option>
                                            <option <?= $select("DF")?> value="DF">Distrito Federal</option>
                                            <option <?= $select("ES")?> value="ES">Espírito Santo</option>
                                            <option <?= $select("GO")?> value="GO">Goiás</option>
                                            <option <?= $select("MA")?> value="MA">Maranhão</option>
                                            <option <?= $select("MT")?> value="MT">Mato Grosso</option>
                                            <option <?= $select("MS")?> value="MS">Mato Grosso do Sul</option>
                                            <option <?= $select("MG")?> value="MG">Minas Gerais</option>
                                            <option <?= $select("PA")?> value="PA">Pará</option>
                                            <option <?= $select("PB")?> value="PB">Paraíba</option>
                                            <option <?= $select("PR")?> value="PR">Paraná</option>
                                            <option <?= $select("PE")?> value="PE">Pernambuco</option>
                                            <option <?= $select("PI")?> value="PI">Piauí</option>
                                            <option <?= $select("RJ")?> value="RJ">Rio de Janeiro</option>
                                            <option <?= $select("RN")?> value="RN">Rio Grande do Norte</option>
                                            <option <?= $select("RS")?> value="RS">Rio Grande do Sul</option>
                                            <option <?= $select("RO")?> value="RO">Rondônia</option>
                                            <option <?= $select("RR")?> value="RR">Roraima</option>
                                            <option <?= $select("SC")?> value="SC">Santa Catarina</option>
                                            <option <?= $select("SP")?> value="SP">São Paulo</option>
                                            <option <?= $select("SE")?> value="SE">Sergipe</option>
                                            <option <?= $select("TO")?> value="TO">Tocantins</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>*Cidade</label>
                                        <input id="city" type="text"
                                        name="city" class="form-control" value="<?= $user->city ?>" placeholder="Cidade" required data-input>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>*Endereço</label>
                                        <input id="address" type="text"
                                        name="address" class="form-control" value="<?= $user->address ?>" placeholder="Endereço" required data-input>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>*Bairro</label>
                                        <input type="text"
                                        name="neighborhood" value="<?= $user->neighborhood ?>" id="neighborhood" class="form-control" placeholder="Complemento" required data-input>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>*Nº</label>
                                        <input type="text"
                                        name="number" value="<?= $user->number ?>" class="form-control" placeholder="Nº" required data-input>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Complemento</label>
                                        <input type="text"
                                        name="complement" value="<?= $user->complement ?>"  class="form-control" placeholder="Complemento" data-input>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>*Celular</label>
                                        <input type="text"
                                        name="phone" value="<?= $user->phone ?>"  class="form-control mask-phone" placeholder="Celular" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>*E-mail</label>
                                        <input type="email"
                                        name="email" value="<?= $user->email; ?>"  class="form-control" placeholder="Melhor e-mail" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Senha</label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="password" id="password" class="form-control" placeholder="Senha de acesso">
                                            <div class="input-group-append">
                                                <span class="btn input-group-text" onclick="getPassword()" id="btn">Gerar Senha</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Graduação</label>
                                        <?php
                                            $graduation = $user->graduation;
                                            $select = function ($value) use ($graduation) {
                                                return ($graduation == $value ? "selected" : "");
                                            };
                                        ?>
                                        <select class="form-control" name="graduation">
                                            <?php foreach($graduations as $graduation): ?>
                                                <option <?= $select($graduation->id); ?> value="<?= $graduation->id ?>"><?= $graduation->title ?></option>
                                            <?php endforeach;   ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Dojo</label>
                                        <select name="dojo[]" class="form-control" id="pieces" multiple>
                                            <?php $dj = explode(",", $user->dojo); foreach ($dj as $dojo): ?>
                                                <option selected value="<?= $dojo ?>"><?= $dojo ?></option>
                                            <?php endforeach;   ?>
                                        </select>
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