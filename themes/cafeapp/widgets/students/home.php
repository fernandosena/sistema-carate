<?php $this->layout("_theme"); ?>

<div class="app_launch_header">
    <div class="app_launch_form_filter app_form"></div>
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
        <div class="app_launch_item header" style="text-alight: center">
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
                       href="<?= url("/app/aluno/{$student->id}"); ?>"><?= str_limit_words($student->fullName(), 3, "...") ?></a>
                </p>
                <p class="category"><?= $student->email ?></p>
                <p class="enrollment">
                    <strong class="badge texto-adaptavel" style="background-color: <?= $student->belt()->color ?>"><?= $student->belt()->title ?></strong>
                </p>
                <p class="price"><strong class="badge bg-<?= ($student->status == 'activated') ? 'success': (($student->status == 'pending') ? 'warning' : 'danger') ?>"><?= ($student->status == 'activated') ? 'Ativo': (($student->status == 'pending') ? 'Pendente' : 'Desativado') ?></strong></span></p>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</section>
