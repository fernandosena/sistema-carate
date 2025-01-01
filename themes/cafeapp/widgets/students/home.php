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
                <?php if(!empty($type) && $type == "black"): ?>
                <th>E-mail</th>
                <?php endif; ?>
                <th>Graduação</th>
                <th>Dojo</th>
                <th>Status</th>
                <th>Renovação</th>
                <th>Graduação</th>
            </thead>
            <tbody>
                <?php
                    $unpaid = 0;
                    $paid = 0;
                    foreach ($students as $student):
                    $data_banco_obj = new DateTime($student->updated_at);
                    $data_atual_obj = new DateTime();
                    $intervalo = $data_atual_obj->diff($data_banco_obj);
                ?>
                    <tr>
                        <td><a title="<?= $student->fullName(); ?>"
                        href="<?= url("/app/aluno/{$type}/{$student->id}"); ?>"><?= str_limit_words($student->fullName(), 3, "...") ?> <?= (calcularIdade($student->datebirth) < 13) ? "<strong class='badge bg-success'>Até 12 anos</strong>": "" ?></a></td>

                        <?php if(!empty($type) && $type == "black"): ?>
                            <td><?= $student->email ?></td>
                        <?php endif; ?>
                        <td><strong class="badge"><?= $student->belt()->title ?></strong></td>
                        <td><?= $student->dojo ?></td>
                        <td><strong class="badge bg-<?= ($student->status == 'activated') ? 'success': (($student->status == 'pending') ? 'warning' : 'danger') ?>"><?= ($student->status == 'activated') ? 'Ativo': (($student->status == 'pending') ? 'Pendente' : 'Desativado') ?></strong></span></td>
                        <td>
                            <?php
                                $verify = verify_renewal_data($student->renewal, $student->last_renewal_data);
                                if($verify && ($student->renewal != "pending")){
                            ?>
                                <a href="#" class="btn bg-success"
                                data-post="<?= url("app/alunos") ?>"
                                data-action="payment"
                                data-user_id="<?= user()->id; ?>"
                                data-student_id="<?= $student->id; ?>"><i class="fa-solid fa-circle-check"></i> Realizar o Pagamento</a>
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
