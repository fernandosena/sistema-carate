<?php $this->layout("_theme"); ?>

<div class="app_launch_header">
    <form class="app_launch_form_filter app_form" action="<?= url("/app/filter"); ?>" method="post">
        <input type="hidden" name="filter" value="<?= $type; ?>"/>

        <select name="status">
            <option value="all" <?= (empty($filter->status) ? "selected" : ""); ?>>Todas</option>
            <option value="activated" <?= (!empty($filter->status) && $filter->status == "activated" ? "selected" : ""); ?>>Ativos</option>
            <option value="deactivated" <?= (!empty($filter->status) && $filter->status == "deactivated" ? "selected" : ""); ?>>Desativados</option>
        </select>

        <select name="category">
            <option value="all">Todas</option>
            <?php foreach ($categories as $category): ?>
                <option <?= (!empty($filter->category) && $filter->category == $category->id ? "selected" : ""); ?>
                        value="<?= $category->id; ?>"><?= $category->title; ?></option>
            <?php endforeach; ?>
        </select>

        <input list="datelist" type="text" class="radius mask-month" name="date"
               placeholder="<?= (!empty($filter->date) ? $filter->date : date("m/Y")); ?>">

        <datalist id="datelist">
            <?php for ($range = -2; $range <= 2; $range++):
                $dateRange = date("m/Y", strtotime(date("Y-m-01") . "+{$range}month"));
                ?>
                <option value="<?= $dateRange; ?>"/>
            <?php endfor; ?>
        </datalist>

        <button class="filter radius transition icon-filter icon-notext"></button>
    </form>

    <div class="app_launch_btn income radius transition icon-plus-circle"
         data-modalopen=".app_modal_student"> Cadastrar Aluno
    </div>
</div>

<section class="app_launch_box">
    <?php if (!$invoices): ?>
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
        foreach ($invoices as $invoice):
            ?>
            <article class="app_launch_item">
                <p class="desc app_invoice_link transition">
                    <a title="<?= $invoice->fullName(); ?>"
                       href="<?= url("/app/aluno/{$invoice->id}"); ?>"><?= str_limit_words($invoice->fullName(),
                            3, "&nbsp;<span class='icon-info icon-notext'></span>") ?></a>
                </p>
                <p class="category"><?= $invoice->email ?></p>
                <p class="enrollment"><?= $invoice->belts()->title ?></p>
                <p class="price"><?= (!empty($invoice->status) && $invoice->status == "activated") ? "Ativo" : "Inativo" ?></p>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</section>
