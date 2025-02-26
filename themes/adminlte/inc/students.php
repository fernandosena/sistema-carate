<form class="app_form" id="address-form" action="<?= $form["url"] ?>" method="post">
    <div class="card-body">
        <!--ACTION SPOOFING-->
        <input type="hidden" name="action" value="<?= !empty($form["data"]) ? "update": "create" ?>"/>
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

        <?php if(!empty($form["type"])): ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>*Professor</label>
                        <?php
                            $instruct = $form["data"]->user_id;
                            $instructSelect = function ($value) use ($instruct) {
                                return ($instruct == $value ? "selected" : "");
                            };
                        ?>
                        <select data-dojo="<?= url("/admin/dojo") ?>" class="form-control" name="teacher">
                            <option value="" select>=== Selecione um professor ===</option>
                            <?php 
                                foreach($form["teachers"] as $teacher):    
                            ?>
                            <option <?= $instructSelect($teacher->id) ?> value="<?= $teacher->id ?>"><?= $teacher->FullName() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>*Nome</label>
                    <input type="text"
                    name="first_name" value="<?= ($form["data"]->first_name) ?>" class="form-control" placeholder="Primeiro nome" required>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>*Sobrenome:</label>
                    <input type="text"
                    name="last_name" value="<?= ($form["data"]->last_name) ?>" class="form-control" placeholder="Último nome" required>
                </div>
            </div>
        </div>
        <div class="row">
            <?php if($form["data"]->level != 5): ?>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>*CPF</label>
                    <input type="text"
                    name="document" value="<?= ($form["data"]->document) ?>" class="form-control mask-doc" placeholder="CPF do usuário" required>
                </div>
            </div>
            <?php endif; ?>
            <div class="<?= ($form["data"]->level != 5) ? "col-sm-6" : "col-sm-12" ?>">
                <div class="form-group">
                    <label>*Nascimento</label>
                    <input type="date"
                    name="datebirth" value="<?= ($form["data"]->datebirth) ?>" class="form-control" placeholder="dd/mm/yyyy" required>
                </div>
            </div>
        </div>
        <?php if(empty($form["type"]) || $form["type"] != "kyus"): ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>*CEP</label>
                    <input id="cep" value="<?= ($form["data"]->zip) ?>" type="text"
                    name="zip" class="form-control" placeholder="CEP" required maxlength="8" minlength="8">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>*Estado</label>
                    <?php
                        $state = $form["data"]->state;
                        $select = function ($value) use ($state) {
                            return ($state == $value ? "selected" : "");
                        };
                    ?>
                    <select class="form-control" name="state" id="state" <?= !empty($form["data"]) ? null: "disabled" ?> required data-input>
                        <option value="" selected>Estado</option>
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
                    name="city" value="<?= ($form["data"]->city) ?>"  class="form-control" placeholder="Cidade" <?= !empty($form["data"]) ? null: "disabled" ?>  required data-input>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>*Endereço</label>
                    <input id="address" value="<?= ($form["data"]->address) ?>"  type="text"
                    name="address" class="form-control" placeholder="Endereço" <?= !empty($form["data"]) ? null: "disabled" ?> required data-input>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>*Bairro</label>
                    <input type="text"
                    name="neighborhood" value="<?= ($form["data"]->neighborhood) ?>" id="neighborhood" class="form-control" placeholder="Complemento" <?= !empty($form["data"]) ? null: "disabled" ?> required data-input>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>*Nº</label>
                    <input type="text"
                    name="number" value="<?= ($form["data"]->number) ?>" class="form-control" placeholder="Nº" <?= !empty($form["data"]) ? null: "disabled" ?> required data-input>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="row">
            <?php if(empty($form["type"]) || $form["type"] != "kyus"): ?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Complemento</label>
                        <input type="text"
                        name="complement" value="<?= ($form["data"]->complement) ?>" class="form-control" placeholder="Complemento" <?= !empty($form["data"]) ? null: "disabled" ?> data-input>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(empty($form["type"]) || $form["type"] != "kyus"): ?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>*Celular</label>
                        <input type="text"
                        name="phone" value="<?= ($form["data"]->phone) ?>" class="form-control mask-phone" placeholder="Celular" required>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="row">
            <?php if(empty($form["type"]) || $form["type"] != "kyus"): ?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>*E-mail</label>
                        <input type="email"
                        name="email" value="<?= ($form["data"]->email) ?>" class="form-control" placeholder="Melhor e-mail" required>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(empty($form["type"])): ?>
            <div class="col-sm-6">
                <div class="form-group">
                    <label><?= !empty($form["data"]) ? null: "*" ?>Senha</label>
                    <div class="input-group mb-3">
                        <input type="text" name="password" id="password" class="form-control" placeholder="Senha de acesso" <?= !empty($form["data"]) ? null: "required" ?>>
                        <div class="input-group-append">
                            <span class="btn input-group-text" onclick="getPassword()" id="btn">Gerar Senha</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>*Graduação</label>
                    <?php
                        $graduation = $form["lastgraduation"]->id;
                        $select = function ($value) use ($graduation) {
                            return ($graduation == $value ? "selected" : "");
                        };
                    ?>
                    <select class="form-control" required name="graduation">
                        <option selected value="">Selecione uma graduação</option>
                        <?php foreach($form["graduations"] as $graduation): ?>
                            <option <?= $select($graduation->id); ?> value="<?= $graduation->id ?>"><?= $graduation->title ?></option>
                        <?php endforeach;   ?>
                    </select>
                </div>
            </div>
            <?php if(empty($form["type"])): ?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>*Dojo</label>
                        <select name="dojo[]" class="form-control" id="pieces" multiple required>
                            <?php if(!empty($form["data"]->dojo)): ?>
                                <?php foreach(explode(",", $form["data"]->dojo) as $dojo): ?>
                                    <option value="<?= $dojo ?>" selected><?= $dojo ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>*Dojo</label>
                        <?php
                            $dojo = $form["data"]->dojo;
                            $edojo = explode(",", $dojo);
                            $selectDojo = function ($value) use ($dojo) {
                                return ($dojo == $value ? "selected" : "");
                            };
                        ?>
                        <select id="dojo" class="form-control" required name="dojo">
                            <?php foreach($edojo as $dj): ?>
                                <option <?= $selectDojo($dj); ?> value="<?= $dj ?>"><?= $dj ?></option>
                            <?php endforeach;   ?>
                        </select>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php if(!empty($form["type"])): ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Descrição</label>
                    <textarea class="form-control"  name="description" placeholder="Descrição (Opcional)"><?= $form["data"]->description ?></textarea>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>*Status</label>
                    <?php
                        $status = $form["data"]->status;
                        $statusSelect = function ($value) use ($status) {
                            return ($status == $value ? "selected" : "");
                        };
                    ?>
                    <select class="form-control" name="status" required>
                        <option <?= $statusSelect("activated") ?> value="activated">Ativo</option>
                        <option <?= $statusSelect("deactivated") ?> value="deactivated">Desativado</option>
                        <option <?= $statusSelect("pending") ?> value="pending">Pendente</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">
        <?= (!empty($form["data"]) ? "Atualizar" : "Criar") ?> Usuário</button>
        <?php if(!empty($form["data"]->id) && $form["data"]->level != 5): ?>
        <a href="#" style="margin-left: 20px; color: red;" class="remove_link icon-warning"
        data-post="<?= $form["url"] ?>"
        data-action="delete"
        data-confirm="ATENÇÃO: Tem certeza que deseja excluir o usuário e todos os dados relacionados a ele? Essa ação não pode ser desfeita!"
        data-user_id="<?= $user->id; ?>">Excluir Usuário</a>
        <?php endif; ?>
    </div>
</form>