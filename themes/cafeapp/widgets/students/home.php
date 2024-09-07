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
        <table class="app_launch_table">
            <thead>
                <th>Aluno</th>
                <th>E-mail</th>
                <th>Faixa</th>
                <th>Status</th>
            </thead>
            <tbody>
                <?php
                    $unpaid = 0;
                    $paid = 0;
                    foreach ($students as $student):
                ?>
                    <tr>
                        <td><a title="<?= $student->fullName(); ?>"
                        href="<?= url("/app/aluno/{$student->id}"); ?>"><?= str_limit_words($student->fullName(), 3, "...") ?></a></td>
                        <td><?= $student->email ?></td>
                        <td><strong class="badge texto-adaptavel" style="background-color: <?= $student->belt()->color ?>"><?= $student->belt()->title ?></strong></td>
                        <td><strong class="badge bg-<?= ($student->status == 'activated') ? 'success': (($student->status == 'pending') ? 'warning' : 'danger') ?>"><?= ($student->status == 'activated') ? 'Ativo': (($student->status == 'pending') ? 'Pendente' : 'Desativado') ?></strong></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>
