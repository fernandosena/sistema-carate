<div class="app_modal_box app_modal_student">
    <p class="title icon-user">Novo Aluno:</p>
    <form class="app_form" action="<?= url("/app/launch"); ?>" method="post">
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

        <div class="label_group">
            <label>
                <span class="field icon-envelope">E-mail:</span>
                <input class="radius" type="text" name="email" placeholder="Ex: exemplo@gmail.com" required/>
            </label>
            <label>
                <span class="field icon-phone">Telefone:</span>
                <input class="radius mask-tel" type="tel" name="phone" placeholder="Ex: (99) 9 9999-9999" required/>
            </label>
        </div>
        <label>
            <span class="field icon-filter">Faixa:</span>
            <select name="category_id">
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category->id; ?>">&ofcir; <?= $category->name; ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>
            <span class="field icon-text">Observação:</span>
            <textarea class="radius" name="description" placeholder="Aluno tranferido da escola xyz"></textarea>
        </label>
        <label class="repeate_item repeate_item_fixed" style="display: none">
            <select name="period">
                <option value="month">&ofcir; Mensal</option>
                <option value="year">&ofcir; Anual</option>
            </select>
        </label>

        <label class="repeate_item repeate_item_enrollment" style="display: none">
            <input class="radius" type="number" value="1" min="1" max="420" placeholder="1 parcela" name="enrollments"/>
        </label>

        <button class="btn radius transition icon-check-square-o">Cadastrar aluno</button>
    </form>
</div>