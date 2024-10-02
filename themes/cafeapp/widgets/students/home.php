<?php $this->layout("_theme"); ?>

<div class="app_launch_header">
    <div class="app_launch_form_filter app_form"></div>
    <?php if($type == "black"): ?>
        <div class="app_launch_btn income radius transition icon-plus-circle"
            data-modalopen=".app_modal_student"> Cadastrar Faixa Preta
        </div>
    <?php else: ?>
        <div class="app_launch_btn income radius transition icon-plus-circle"
            data-modalopen=".app_modal_student_kyus"> Cadastrar Kyus
        </div>
    <?php endif; ?>
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
                <?php if(!empty($type) && $type == "black"): ?>
                <th>E-mail</th>
                <?php endif; ?>
                <th>Graduação</th>
                <th>Dojo</th>
                <th>Status</th>
                <th>Renovação</th>
            </thead>
            <tbody>
                <?php
                    $unpaid = 0;
                    $paid = 0;
                    foreach ($students as $student):
                ?>
                    <tr>
                        <td><a title="<?= $student->fullName(); ?>"
                        href="<?= url("/app/aluno/{$type}/{$student->id}"); ?>"><?= str_limit_words($student->fullName(), 3, "...") ?></a></td>

                        <?php if(!empty($type) && $type == "black"): ?>
                            <td><?= $student->email ?></td>
                        <?php endif; ?>
                        <td><strong class="badge"><?= $student->belt()->title ?></strong></td>
                        <td><?= $student->dojo ?></td>
                        <td><strong class="badge bg-<?= ($student->status == 'activated') ? 'success': (($student->status == 'pending') ? 'warning' : 'danger') ?>"><?= ($student->status == 'activated') ? 'Ativo': (($student->status == 'pending') ? 'Pendente' : 'Desativado') ?></strong></span></td>
                        <td>
                            <?php
                                $verify = verify_renewal_data($student->renewal, $student->last_renewal_data);
                                if($verify){
                            ?>
                                <a href="#" class="btn bg-success"
                                data-post="<?= url("app/alunos") ?>"
                                data-action="payment"
                                data-user_id="<?= user()->id; ?>"
                                data-student_id="<?= $student->id; ?>"><i class="fa-solid fa-circle-check"></i> <?= $verify ?></a>
                            <?php
                                }else{
                                    if($student->renewal == "pending"){
                                        echo "Em analise";
                                    }else{
                                        echo "Usuário atualizado";
                                    }
                                }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>
