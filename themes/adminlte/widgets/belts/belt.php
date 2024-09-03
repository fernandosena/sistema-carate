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
                                <label>*Senha</label>
                                <input type="password"
                                name="password" class="form-control mask-doc" placeholder="Senha de acesso" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Level</label>
                                <select class="form-control"  name="level" required>
                                    <option value="1">Usuário</option>
                                    <option value="5">Admin</option>
                                </select>
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
                    <button type="submit" class="btn btn-primary">Criar Usuário</button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= $user->fullName(); ?></h3>
            </div>
            <form class="app_form" action="<?= url("/admin/users/user/{$user->id}"); ?>" method="post">
                <div class="card-body">
                    <!--ACTION SPOOFING-->
                    <input type="hidden" name="action" value="update"/>
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
                                name="datebirth" value="<?= date_fmt($user->datebirth, "Y-m-d"); ?>" class="form-control" placeholder="dd/mm/yyyy">
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
                                <label>*Senha</label>
                                <input type="password"
                                name="password" class="form-control mask-doc" placeholder="Senha de acesso">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Level</label>
                                <?php
                                    $level = $user->level;
                                    $select = function ($value) use ($level) {
                                        return ($level == $value ? "selected" : "");
                                    };
                                ?>
                                <select class="form-control" name="level" required>
                                    <option value="1" <?= $select(1); ?> >Usuário</option>
                                    <option <?= $select(5); ?>  value="5">Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Status</label>
                                <?php
                                    $status = $user->status;
                                    $select = function ($value) use ($status) {
                                        return ($status == $value ? "selected" : "");
                                    };
                                ?>
                                <select class="form-control" name="status" required>
                                    <option <?= $select("registered"); ?> value="registered">Registrado</option>
                                    <option <?= $select("confirmed"); ?>  value="confirmed">Confirmado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Atualizar Usuário</button>

                    <a href="#" class="text-danger icon-warning"
                       data-post="<?= url("/admin/users/user/{$user->id}"); ?>"
                       data-action="delete"
                       data-confirm="ATENÇÃO: Tem certeza que deseja excluir o usuário e todos os dados relacionados a ele? Essa ação não pode ser feita!"
                       data-user_id="<?= $user->id; ?>">Excluir Usuário</a>
                </div>
            </form>
        </div>
    <?php endif; ?>
</section>