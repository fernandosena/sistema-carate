<div class="app_modal_box app_modal_student">
    <p class="title icon-user">Novo Aluno:</p>
    <form class="app_form" action="<?= url("/app/alunos"); ?>" method="post">
        <input type="hidden" name="action" value="create"/>

        <div class="app_formbox_photo">
            <div class="rounded j_profile_image thumb" style="background-image: url('<?= $photo; ?>')"></div>
            <div><input data-image=".j_profile_image" type="file" class="radius"  name="photo"/></div>
        </div>
        <div class="label_group">
            <label>
                <span class="field icon-user">Nome:</span>
                <input class="radius" type="text" name="first_name" placeholder="Ex: Hugo" required/>
            </label>
            <label>
                <span class="field icon-user">Sobrenome:</span>
                <input class="radius" type="text" name="last_name" placeholder="Ex: Silva" required/>
            </label>
        </div>
        <label>
            <span class="field icon-envelope">E-mail:</span>
            <input class="radius" type="text" name="email" placeholder="Ex: exemplo@gmail.com" required/>
        </label>
        <div class="label_group">
            <label>
                <span class="field icon-briefcase">CPF:</span>
                <input class="radius mask-doc" type="text" name="document" placeholder="Ex: 123.456.789-01" required/>
            </label>
            <label>
                <span class="field icon-phone">Telefone:</span>
                <input class="radius mask-phone" type="phone" name="phone" placeholder="Ex: (99) 9 9999-9999" required/>
            </label>
        </div>
        <label>
            <span class="field icon-filter">Faixa:</span>
            <select name="belts">
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category->id; ?>">&ofcir; <?= $category->title; ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>
            <span class="field icon-text">Observação:</span>
            <textarea class="radius" name="description" placeholder="Aluno tranferido da escola xyz"></textarea>
        </label>

        <button class="btn radius transition icon-check-square-o">Cadastrar aluno</button>
    </form>
</div>