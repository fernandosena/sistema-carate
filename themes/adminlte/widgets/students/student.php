<?php $this->layout("_admin"); ?>

<section class="dash_content_app">
    <?php if (!$student): ?>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Cadastrar Aluno</h3>
            </div>
            <form class="app_form" action="<?= url("/admin/students/student"); ?>" method="post">
                <div class="card-body">
                    <!--ACTION SPOOFING-->
                    <input type="hidden" name="action" value="create"/>
                    <input type="hidden" name="type" value="<?= $type ?>"/>
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
                                <select class="form-control" name="teacher">
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
                                <label>*Telefone</label>
                                <input type="tel"
                                name="phone" class="form-control mask-phone" required>
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
                                <label>* CPF</label>
                                <input type="text"
                                name="document" class="form-control mask-doc" placeholder="CPF do usuário" required>
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
                                <textarea name="description" class="form-control" placeholder="Descrição do aluno"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Graduação</label>
                                <select class="form-control" name="belts" required>
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
                                            <h6><?= $historic->findBelt($historic->graduation_id)->title ?></h6>
                                            <p class="mb-0 text-muted"><?= $historic->description ?></p>
                                            <o class="text-muted"><?= date_fmt($historic->created_at, "d/m/y \à\s H\hi"); ?></p>
                                        </li>
                                    <?php $c++;endforeach; ?>
                                </ul>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="profile">
                                <form class="app_form" id="address-form" action="<?= url("/admin/students/student/{$student->id}"); ?>" method="post">
                                    <div class="card-body">
                                        <!--ACTION SPOOFING-->
                                        <input type="hidden" name="action" value="update"/>
                                        <input type="hidden" name="type" value="<?= $type ?>"/>
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
                                                    name="first_name" value="<?= $student->first_name; ?>" class="form-control" placeholder="Primeiro nome" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>*Sobrenome:</label>
                                                    <input type="text"
                                                    name="last_name" value="<?= $student->last_name; ?>" class="form-control" placeholder="Último nome" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>*CPF</label>
                                                    <input type="text"
                                                    name="document" value="<?= $student->document; ?>" class="form-control mask-doc" placeholder="CPF do usuário" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>*Nascimento</label>
                                                    <input type="date"
                                                    name="datebirth" value="<?= (!empty($student->datebirth)) ? date_fmt($student->datebirth, "Y-m-d") : null; ?>" class="form-control" placeholder="dd/mm/yyyy">
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($type == "black"): ?>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>*CEP</label>
                                                    <input type="text" id="cep" type="text"
                                                    name="zip" class="form-control" value="<?= $student->zip; ?>" placeholder="CEP">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>*Estado</label>
                                                    <?php
                                                        $state = $student->state;
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
                                                    name="city" class="form-control" value="<?= $student->city ?>" placeholder="Cidade" required data-input>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>*Endereço</label>
                                                    <input id="address" type="text"
                                                    name="address" class="form-control" value="<?= $student->address ?>" placeholder="Endereço" required data-input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>*Bairro</label>
                                                    <input type="text"
                                                    name="neighborhood" value="<?= $student->neighborhood ?>" id="neighborhood" class="form-control" placeholder="Complemento" required data-input>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>*Nº</label>
                                                    <input type="text" name="number" value="<?= $student->number ?>" class="form-control" placeholder="Nº" required data-input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Complemento</label>
                                                    <input type="text"
                                                    name="complement" value="<?= $student->complement ?>"  class="form-control" placeholder="Complemento" data-input>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>*Celular</label>
                                                    <input type="text"
                                                    name="phone" value="<?= $student->phone ?>"  class="form-control mask-phone" placeholder="Celular" required>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <div class="row">
                                            <?php if($type == "black"): ?>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>*E-mail</label>
                                                        <input type="email"
                                                        name="email" value="<?= $student->email; ?>"  class="form-control" placeholder="Melhor e-mail" required>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>*Graduação</label>
                                                    <?php
                                                        $graduation = $student->graduation;
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
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <?php
                                                        $status = $student->status;
                                                        $selectStatus = function ($value) use ($status) {
                                                            return ($status == $value ? "selected" : "");
                                                        };
                                                    ?>
                                                    <select class="form-control" name="status" required>
                                                        <option <?= $selectStatus("pending")?> value="pending">Pendente</option>
                                                        <option <?= $selectStatus("activated")?> value="activated">Ativo</option>
                                                        <option <?= $selectStatus("deactivated")?> value="deactivated">Desativado</option>
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