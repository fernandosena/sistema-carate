<div class="app_modal_box app_modal_student">
    <?php if(empty($student) || (!empty($student) && $student->status != "pending")): ?>
        <p class="title icon-user"><?= (!empty($student)) ? "Atualizar Aluno" : "Novo Aluno" ?>:</p>
        <form class="app_form" action="<?= url("/app/alunos"); ?>" method="post">
            <input type="hidden" name="action" value="<?= (!empty($student)) ? "update" : "create" ?>"/>
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
            <label>
                <span class="field icon-envelope">E-mail:</span>
                <input class="radius" type="text" name="email" value="<?= ($student->email) ?? null ?>" placeholder="Ex: exemplo@gmail.com" required/>
            </label>
            <div class="label_group">
                <label>
                    <span class="field icon-briefcase">CPF:</span>
                    <input class="radius mask-doc" type="text" value="<?= ($student->document) ?? null ?>" name="document" placeholder="Ex: 123.456.789-01" required/>
                </label>
                <label>
                    <span class="field icon-phone">Telefone:</span>
                    <input class="radius mask-phone" type="phone" value="<?= ($student->phone) ?? null ?>" name="phone" placeholder="Ex: (99) 9 9999-9999" required/>
                </label>
            </div>
            <?php if (empty($student)): ?>
                <label>
                    <span class="field icon-filter">Faixa:</span>
                    <select name="belts">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->id ?>">&ofcir; <?= $category->title; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
            <?php endif; ?>

            <label>
                <span class="field icon-text">Observação:</span>
                <textarea class="radius" name="description" value="<?= ($student->description) ?? null ?>" placeholder="Aluno tranferido da escola xyz"></textarea>
            </label>

            <button class="btn radius transition icon-check-square-o"><?php (!empty($student->belts)) ? "Atualizar" : "Cadastrar" ?> aluno</button>
        </form>
    <?php else: ?>
        <div class="message warning icon-warning">
            o aluno ainda está em análise, tente novamente mais tarde
        </div>
    <?php endif; ?>
</div>