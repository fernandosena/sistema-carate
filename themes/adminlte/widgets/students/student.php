<?php $this->layout("_admin"); ?>

<section class="dash_content_app">
    <?php if (!$student): ?>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= (!empty($student)) ? $student->fullName() : "Criar novo aluno"; ?></h3>
            </div>
            <form class="app_form" action="<?= url("/admin/students/student/{$student->id}"); ?>" method="post">
                <div class="card-body">
                    <!--ACTION SPOOFING-->
                    <input type="hidden" name="action" value="create"/>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Professor</label>
                                <input type="text"
                                name="teacher"  class="form-control" placeholder="Primeiro nome" required>
                            </div>
                        </div>
                    </div>
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
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>*E-mail</label>
                                <input type="email"
                                name="email" class="form-control" placeholder="Melhor e-mail" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Status</label>
                                <select class="form-control" name="status" required>
                                    <option value="registered">Registrado</option>
                                    <option value="confirmed">Confirmado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Criar Aluno</button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= $student->fullName(); ?></h3>
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
                                <?php
                                    $user_id = $student->user_id;
                                    $select = function ($value) use ($user_id) {
                                        return ($user_id == $value ? "selected" : "");
                                    };
                                ?>
                                <select class="form-control" name="genre">
                                    <?php 
                                        foreach($teachers as $teacher):    
                                    ?>
                                    <option <?= $select($teacher->id); ?> value="<?= $teacher->id ?>"><?= $teacher->FullName() ?></option>
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
                                <label>Genero</label>
                                <?php
                                    $genre = $student->genre;
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
                                <label>Telefone</label>
                                <input type="tel"
                                name="phone" value="<?= $student->phone; ?>" class="form-control mask-phone" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nascimento</label>
                                <input type="date"
                                name="datebirth" value="<?= date_fmt($student->datebirth, "Y-m-d"); ?>" class="form-control" placeholder="dd/mm/yyyy">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>CPF</label>
                                <input type="text"
                                name="document" class="form-control mask-doc" value="<?= $student->document; ?>" placeholder="CPF do usuário">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>*E-mail</label>
                                <input type="email"
                                name="email" value="<?= $student->email; ?>"  class="form-control" placeholder="Melhor e-mail" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Descrição</label>
                                <textarea
                                name="description"  class="form-control" placeholder="Descrição do aluno"><?= $student->description; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Faixa</label>
                                <?php
                                    $status = $student->belts;
                                    $select = function ($value) use ($status) {
                                        return ($status == $value ? "selected" : "");
                                    };
                                ?>
                                <select class="form-control" name="status" required>
                                    <?php 
                                        foreach($belts as $belt):    
                                    ?>
                                    <option <?= $select($belt->id); ?> value="<?= $belt->id ?>"><?= $belt->title ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Status</label>
                                <?php
                                    $status = $student->status;
                                    $select = function ($value) use ($status) {
                                        return ($status == $value ? "selected" : "");
                                    };
                                ?>
                                <select class="form-control" name="status" required>
                                    <option <?= $select("activated"); ?> value="activated">Ativo</option>
                                    <option <?= $select("deactivated"); ?>  value="deactivated">Desativado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Atualizar Aluno</button>
                    <a href="#" class="text-danger icon-warning"
                       data-post="<?= url("/admin/users/user/{$student->id}"); ?>"
                       data-action="delete"
                       data-confirm="ATENÇÃO: Tem certeza que deseja excluir o aluno e todos os dados relacionados a ele? Essa ação não pode ser feita!"
                       data-user_id="<?= $student->id; ?>">Excluir Aluno</a>
                </div>
            </form>
        </div>
    <?php endif; ?>
</section>