<div class="app_modal_box app_modal_student_kyus">
    <?php if(empty($student) || (!empty($student) && $student->status != "pending")): ?>
        <p class="title icon-user"><?= (!empty($student)) ? "Atualizar Kyus" : "Novo Kyus" ?>:</p>
        <form class="app_form" id="address-form" action="<?= url("/app/alunos"); ?>" method="post">
            <input type="hidden" name="action" value="<?= (!empty($student)) ? "update" : "create" ?>"/>
            <input type="hidden" name="type" value="kyus">
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
                            <option <?= $select($graduation->id); ?> value="<?= $graduation->id ?>">&ofcir; <?= $graduation->title; ?> - <?= $graduation->description; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
            <?php endif; ?>

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