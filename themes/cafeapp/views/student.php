<div class="app_modal_box app_modal_student">
    <?php if(empty($student) || (!empty($student) && $student->status != "pending")): ?>
        <p class="title icon-user"><?= (!empty($student)) ? "Atualizar Faixa Preta" : "Novo Faixa Preta" ?>:</p>
        <form class="app_form address-form" action="<?= url("/app/alunos"); ?>" method="post">
            <input type="hidden" name="action" value="<?= (!empty($student)) ? "update" : "create" ?>"/>
            <input type="hidden" name="type" value="black">
            <input type="hidden" name="id" value="<?= ($student->id) ?? null ?>"/>
            <?php
                if (!empty($student)) {
                    $photo = ($student->photo() ? image($student->photo, 300, 300) :
                    theme("/assets/images/avatar.jpg", CONF_VIEW_ADMIN));
                }
            ?>
            <div class="app_formbox_photo">
                <div class="rounded j_profile_image thumb" style="background-image: url('<?= $photo; ?>')"></div>
                <div><input data-image=".j_profile_image" type="file" class="radius"  name="photo"/></div>
            </div>
            <div class="label_group">
                <label>
                    <span class="field icon-user">Nome:</span>
                    <input class="radius" type="text" name="first_name" value="<?= ($student->first_name) ?? null ?>" placeholder="Ex: Hugo" required/>
                </label>
                <label>
                    <span class="field icon-user">Sobrenome:</span>
                    <input class="radius" type="text" name="last_name" value="<?= ($student->last_name) ?? null ?>" placeholder="Ex: Silva" required/>
                </label>
            </div>
            <div class="label_group">
                <label>
                    <span class="field icon-briefcase">CPF:</span>
                    <input class="radius mask-doc" placeholder="CPF do usuário" type="text" name="document" value="<?= ($student->document) ?? null ?>" required/>
                </label>
                <label>
                    <span class="field icon-heartbeat">Nascimento:</span>
                    <input type="date"
                    name="datebirth" class="radius" value="<?= (!empty($student->datebirth)) ? date_fmt($student->datebirth, "Y-m-d") : null; ?>" placeholder="dd/mm/yyyy" required/>
                </label>
            </div>
            <div class="label_group">
                <label>
                    <span class="field icon-map-marker">CEP:</span>
                    <input class="radius cep" name="zip" value="<?= $student->zip; ?>" placeholder="CEP" required maxlength="8" minlength="8"/>
                </label>
                <label>
                    <span class="field icon-map-marker">Estado:</span>
                    <?php
                        $state = $student->state;
                        $select = function ($value) use ($state) {
                            return ($state == $value ? "selected" : "");
                        };
                    ?>
                    <select class="radius state" <?= (!empty($student)) ? null : "disabled" ?> name="state" required data-input>
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
                </label>
            </div>
            <div class="label_group">
                <label>
                    <span class="field icon-map-marker">Cidade:</span>
                    <input type="text" name="city" class="radius city"  <?= (!empty($student)) ? null : "disabled" ?> value="<?= $student->city ?>" placeholder="Cidade" required data-input>
                </label>
                <label>
                    <span class="field icon-map-marker">Endereço:</span>
                    <input type="text" name="address" class="radius address" value="<?= $student->address ?>" placeholder="Endereço"  <?= (!empty($student)) ? null : "disabled" ?> required data-input>
                </label>
            </div>
            <div class="label_group">
                <label>
                    <span class="field icon-map-marker">Bairro:</span>
                    <input type="text" name="neighborhood" value="<?= $student->neighborhood ?>" class="radius neighborhood"  <?= (!empty($student)) ? null : "disabled" ?> placeholder="Complemento" required data-input>
                </label>
                <label>
                    <span class="field icon-map-marker">Número:</span>
                    <input type="text" name="number" value="<?= $student->number ?>" class="radius" placeholder="Nº" <?= (!empty($student)) ? null : "disabled" ?> required data-input>
                </label>
            </div>
            <div class="label_group">
                <label>
                    <span class="field icon-map-marker">Complemento:</span>
                    <input type="text" name="complement"  <?= (!empty($student)) ? null : "disabled" ?> value="<?= $student->complement ?>" class="radius" placeholder="Complemento" data-input>
                </label>
                <label>
                    <span class="field icon-phone">Celular:</span>
                    <input type="text" name="phone" value="<?= $student->phone ?>"  class="radius mask-phone" placeholder="Ex: (99) 9 9999-9999" required>
                </label>
            </div>
            <label>
                <span class="field icon-envelope">E-mail:</span>
                <input class="radius" type="text" name="email" value="<?= ($student->email) ?? null ?>" placeholder="Ex: exemplo@gmail.com" required/>
            </label>
            <?php if (empty($student)): ?>
                <label>
                    <span class="field icon-filter">Graduação:</span>
                    <?php
                        $graduation = $student->graduation;
                        $select = function ($value) use ($graduation) {
                            return ($graduation == $value ? "selected" : "");
                        };
                    ?>
                    <select name="graduation">
                        <?php foreach ($graduations as $graduation): ?>
                            <option <?= $select($graduation->id); ?> value="<?= $graduation->id ?>">&ofcir; <?= $graduation->title; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
            <?php endif; ?>

            <label>
                <span class="field icon-filter">Dojo:</span>
                <?php
                    $dojo = $student->dojo;
                    $select = function ($value) use ($dojo) {
                        return ($dojo == $value ? "selected" : "");
                    };
                ?>
                <select name="dojo">
                    <?php foreach (explode(",", user()->dojo) as $dojo): ?>
                        <option <?= $select($dojo); ?> value="<?= $dojo ?>">&ofcir; <?= $dojo; ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>
                <span class="field icon-text">Observação:</span>
                <textarea class="radius" name="description" placeholder="Aluno tranferido da escola xyz"><?= ($student->description) ?? null ?></textarea>
            </label>

            <button class="btn radius transition icon-check-square-o"><?= (!empty($student)) ? "Atualizar" : "Cadastrar" ?> aluno</button>
        </form>
    <?php else: ?>
        <div class="message warning icon-warning">
            o aluno ainda está em análise, tente novamente mais tarde
        </div>
    <?php endif; ?>
</div>