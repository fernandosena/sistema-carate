<?php $this->layout("_theme"); ?>

<div class="app_formbox app_widget">
    <form class="app_form" method="post">
        <input type="hidden" name="update" value="true"/>

        <div class="app_formbox_photo">
            <div class="rounded j_profile_image thumb" style="background-image: url('<?= $photo; ?>')"></div>
        </div>

        <div class="label_group">
                <label>
                    <span class="field icon-user">Nome:</span>
                    <input class="radius" type="text" name="first_name" value="<?= ($user->first_name) ?? null ?>" placeholder="Ex: Hugo" disabled/>
                </label>
                <label>
                    <span class="field icon-user">Sobrenome:</span>
                    <input class="radius" type="text" name="last_name" value="<?= ($user->last_name) ?? null ?>" placeholder="Ex: Silva" disabled/>
                </label>
            </div>
            <div class="label_group">
                <label>
                    <span class="field icon-briefcase">CPF:</span>
                    <input class="radius mask-doc" placeholder="CPF do usuário" type="text" name="document" value="<?= ($user->document) ?? null ?>" disabled/>
                </label>
                <label>
                    <span class="field icon-heartbeat">Nascimento:</span>
                    <input type="date"
                    name="datebirth" class="radius" value="<?= (!empty($user->datebirth)) ? date_fmt($user->datebirth, "Y-m-d") : null; ?>" placeholder="dd/mm/yyyy" disabled/>
                </label>
            </div>
            <div class="label_group">
                <label>
                    <span class="field icon-map-marker">CEP:</span>
                    <input class="radius" name="zip" value="<?= $user->zip; ?>" placeholder="CEP" disabled maxlength="8" minlength="8" disabled/>
                </label>
                <label>
                    <span class="field icon-map-marker">Estado:</span>
                    <?php
                        $state = $user->state;
                        $select = function ($value) use ($state) {
                            return ($state == $value ? "selected" : "");
                        };
                    ?>
                    <select class="radius state" <?= (!empty($student)) ? null : "disabled" ?> name="state" disabled data-input>
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
                    <input type="text" name="city" class="radius city"  <?= (!empty($student)) ? null : "disabled" ?> value="<?= $user->city ?>" placeholder="Cidade" disabled data-input>
                </label>
                <label>
                    <span class="field icon-map-marker">Endereço:</span>
                    <input type="text" name="address" class="radius address" value="<?= $user->address ?>" placeholder="Endereço"  <?= (!empty($student)) ? null : "disabled" ?> disabled data-input>
                </label>
            </div>
            <div class="label_group">
                <label>
                    <span class="field icon-map-marker">Bairro:</span>
                    <input type="text" name="neighborhood" value="<?= $user->neighborhood ?>" class="radius neighborhood"  <?= (!empty($student)) ? null : "disabled" ?> placeholder="Complemento" disabled data-input>
                </label>
                <label>
                    <span class="field icon-map-marker">Número:</span>
                    <input type="text" name="number" value="<?= $user->number ?>" class="radius" placeholder="Nº" <?= (!empty($student)) ? null : "disabled" ?> disabled data-input>
                </label>
            </div>
            <div class="label_group">
                <label>
                    <span class="field icon-map-marker">Complemento:</span>
                    <input type="text" name="complement"  <?= (!empty($student)) ? null : "disabled" ?> value="<?= $user->complement ?>" class="radius" placeholder="Complemento" data-input>
                </label>
                <label>
                    <span class="field icon-phone">Celular:</span>
                    <input type="text" name="phone" value="<?= $user->phone ?>"  class="radius mask-phone" placeholder="Ex: (99) 9 9999-9999" disabled>
                </label>
            </div>
            <label>
                <span class="field icon-envelope">E-mail:</span>
                <input class="radius" type="text" name="email" value="<?= ($user->email) ?? null ?>" placeholder="Ex: exemplo@gmail.com" disabled/>
            </label>
            <label>
                <span class="field icon-filter">Dojos:</span>
                <input class="radius" type="text" name="email" value="<?= ($user->dojo) ?? null ?>" placeholder="Dojos" disabled/>
            </label>
    </form>
</div>