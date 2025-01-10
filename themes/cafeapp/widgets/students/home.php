<?php $this->layout("_theme"); ?>

<div class="app_launch_header">
    <div class="app_launch_form_filter app_form"></div>
    <?php if($type == "black"): ?>
        <div class="app_launch_btn income radius transition icon-plus-circle"
            data-modalopen=".app_modal_student"> Cadastrar Dan
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
                <th>E-mail</th>
                <th>Graduação</th>
                <th>Dojo</th>
                <th>Status</th>
                <th>Renovação</th>
                <th>Graduação</th>
            </thead>
            <tbody>
                <?php
                    foreach ($students as $student):
                    $budges = false;
                    $btnOptions = false;
                    $btnCancel = false;
                    $lastPayment = $student->paymentsPendingLast();

                    //Verifica se existe um ultimo pagamento (oportunidade para cancelar)
                    $paymentsActivatedLast = $student->paymentsActivatedLast();

                    if(!$lastPayment){
                        if($paymentsActivatedLast){
                            $budges = verify_renew($paymentsActivatedLast->created_at);
                        }else{
                            $budges = verify_renew($student->created_at);
                        }
                        if($budges){
                            $btnOptions = true;
                        }
                    }else{
                        $dataPayment = new DateTime($lastPayment->created_at);
                        $now = new DateTime();
                        $diferenca = $now->diff($dataPayment);

                        if($diferenca->days <= 0){
                            $btnCancel = true;
                        }
                    }
                ?>
                    <tr>
                        <td><a title="<?= $student->fullName(); ?>"
                        href="<?= url("/app/aluno/{$type}/{$student->id}"); ?>"><?= str_limit_words($student->fullName(), 3, "...") ?> <?= (calcularIdade($student->datebirth) < 13) ? "<strong class='badge bg-success'>Até 12 anos</strong>": "" ?></a></td>

                        <td><?= $student->email ?></td>
                        <td><strong class="badge"><?= $student->getLastGraduation()->title ?></strong></td>
                        <td><?= $student->dojo ?></td>
                        <td><strong class="badge bg-<?= ($student->status == 'activated') ? 'success': (($student->status == 'pending') ? 'warning' : 'danger') ?>"><?= ($student->status == 'activated') ? 'Ativo': (($student->status == 'pending') ? 'Pendente' : 'Desativado') ?></strong></span></td>
                        <td>
                            <?php if($btnOptions): ?>
                                <a href="#" class="btn bg-success"
                                data-post="<?= url("app/alunos") ?>"
                                data-action="payment"
                                data-type="create"
                                data-student_id="<?= $student->id; ?>"><i class="fa-solid fa-circle-check"></i> Renovar afiliação</a>
                            <?php endif; ?>
                            <?php  if($btnCancel): ?>
                                <a href="#" class="btn bg-warning"
                                data-post="<?= url("app/alunos") ?>"
                                data-action="payment"
                                data-type="cancel"
                                data-student_id="<?= $student->id; ?>"><i class="fa-solid fa-circle-check"></i> Cancelar </a>
                            <?php endif; ?>
                            <?php  if(!$budges && !$btnCancel && !$btnOptions): ?>
                                Atualizado
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                                if($student->historicbeltscount()){
                            ?>
                                <a href="#" class="btn bg-warning"
                                data-post="<?= url("/app/alunos/faixa"); ?>"
                                data-action="update-reverse"
                                data-id="<?= $student->id ?>"
                                data-type="<?= $student->type; ?>"><i class="fa-solid fa-circle-check"></i> Cancelar graduação</a>
                            <?php
                                }else{
                            ?>  
                                <?php if($student->status == "activated"): ?>
                                <a href="#" class="btn bg-success"
                                data-post="<?= url("/app/alunos/faixa"); ?>"
                                data-action="update-graduation"
                                data-id="<?= $student->id ?>"
                                data-type="<?= $student->type; ?>"><i class="fa-solid fa-circle-check"></i> Subir de graduação</a>
                                <?php else: ?>
                                    Atualizada
                                <?php endif ?>
                            <?php
                                }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>
