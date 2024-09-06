<?php $this->layout("_theme"); ?>

<div class="app_launch_header">
    <form class="app_launch_form_filter app_form" action="<?= url("/app/filter"); ?>" method="post">
        <input type="hidden" name="filter" value="<?= $type; ?>"/>
        <div class="label_group_div">
            <label>
                <span class="field">Status:</span>
                <select name="status">
                    <option value="all" <?= (empty($filter->status) ? "selected" : ""); ?>>Todas</option>
                    <option value="activated" <?= (!empty($filter->status) && $filter->status == "activated" ? "selected" : ""); ?>>Ativos</option>
                    <option value="deactivated" <?= (!empty($filter->status) && $filter->status == "deactivated" ? "selected" : ""); ?>>Desativados</option>
                </select>
            </label>
            <label>
                <span class="field">Faixas:</span>
                <select name="belt">
                    <option value="all">Todas</option>
                    <?php foreach ($belts as $belt): ?>
                        <option <?= (!empty($filter->category) && $filter->category == $belt->id ? "selected" : ""); ?>
                                value="<?= $belt->id; ?>"><?= $belt->title; ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <button class="filter radius transition icon-filter icon-notext"></button> 
        </div>
    </form>

    <div class="app_launch_btn income radius transition icon-plus-circle"
         data-modalopen=".app_modal_student"> Cadastrar Aluno
    </div>
</div>

<section class="app_launch_box">
    <?php if (!$students): ?>
        <?php if (empty($filter->status)): ?>
            <div class="message info icon-info">Ainda não existe alunos
                cadastrados.
            </div>
        <?php else: ?>
            <div class="message info icon-info">Não existem alunos para o filtro aplicado.
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="app_launch_item header">
            <p class="desc">Aluno</p>
            <p class="category">E-mail</p>
            <p class="enrollment">Faixa</p>
            <p class="price">Status</p>
        </div>
        <?php
        $unpaid = 0;
        $paid = 0;
        foreach ($students as $student):
            ?>
            <article class="app_launch_item">
                <p class="desc app_invoice_link transition">
                    <a title="<?= $student->fullName(); ?>"
                       href="<?= url("/app/aluno/{$student->id}"); ?>"><?= str_limit_words($student->fullName(),
                            3, "...") ?></a>
                </p>
                <p class="category"><?= $student->email ?></p>
                <p class="enrollment"><?= $student->belt()->title ?></p>
                <p class="price"><?= (!empty($student->status) && $student->status == "activated") ? "Ativo" : "Inativo" ?></p>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</section>
