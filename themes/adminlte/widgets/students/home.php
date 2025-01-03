<?php $this->layout("_admin"); ?>
<?php if(!empty($students)): ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lista de Alunos</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Foto</th>
                                        <th>Nome</th>
                                        <th>Professor</th>
                                        <th>Graduação</th>
                                        <th>Status</th>
                                        <th>Pagamento</th>
                                        <th>Multa</th>
                                        <th>Atualizar Graduação</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $student):
                                        $studentPhoto = ($student->photo() ? image($student->photo, 300, 300) :
                                        theme("/assets/images/avatar.jpg", CONF_VIEW_ADMIN));
                                    ?>
                                    <tr>
                                        <?php 
                                            //Verifica se existe algum pagamento pendente
                                            $verify = false;
                                            $btnOptions = false;
                                            $btnCancel = false;
                                            $budges = false;
                                            $paymentsPending = $student->paymentsPendingId();

                                            //Verifica se existe um ultimo pagamento (oportunidade para cancelar)
                                            $lastPayment = $student->paymentsActivatedLast();

                                            if($paymentsPending){
                                                $btnOptions = true;
                                            }else{
                                                if($lastPayment){
                                                    $dataPayment = new DateTime($lastPayment->created_at);
                                                    $now = new DateTime();
                                                    $diferenca = $now->diff($dataPayment);

                                                    $budges = verify_renew($lastPayment->created_at);

                                                    if($diferenca->days <= 0){
                                                        $btnCancel = true;
                                                    }else{
                                                        $verify = true;
                                                    }
                                                }else{
                                                    $budges = verify_renew($student->created_at);                                                    
                                                }
                                            }
                                        ?>
                                        <td>
                                            <img class="profile-user-img img-fluid img-circle img-table" src="<?= $studentPhoto; ?>" alt="<?= $student->fullName(); ?>">
                                        </td>
                                        <td><?= $student->fullName(); ?> <?= (calcularIdade($student->datebirth) < 13) ? "<strong class='badge bg-warning'>Até 12 anos</strong>": "" ?></td>
                                        <td><?= $student->teacher()->first_name; ?></td>
                                        <td><?= $student->getLastGraduation()->title; ?></td>
                                        <td>
                                            <?php if($student->status == "activated"): ?>
                                                <strong class="badge bg-success">Ativado</strong>
                                            <?php else:?>
                                                <a href="#" class="btn bg-success"
                                                data-postbtn="<?= url("admin/post/students/status") ?>"
                                                data-type="activated"
                                                data-student_id="<?= $student->id; ?>"><i class="fa-solid fa-circle-check"></i> Aprovar</a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if($btnOptions): ?>
                                                <a href="#" class="btn bg-success"
                                                data-post="<?= url("admin/post/students/payment") ?>"
                                                data-type="activated"
                                                data-id="<?= $paymentsPending; ?>">
                                                    <i class="fa-solid fa-circle-check"></i> Aprovar
                                                </a>
                                                <a href="#" class="btn bg-danger"
                                                data-post="<?= url("admin/post/students/payment") ?>"
                                                data-type="disapprove"
                                                data-id="<?= $paymentsPending; ?>">
                                                    <i class="fa-sharp fa-solid fa-xmark"></i> Reprovar
                                                </a>
                                            <?php endif; ?>
                                            
                                            <?php  if($btnCancel): ?>
                                                <a href="#" class="btn bg-danger"
                                                data-post="<?= url("admin/post/students/payment") ?>"
                                                data-type="disapprove"
                                                data-id="<?= $lastPayment->id ?>">
                                                    <i class="fa-sharp fa-solid fa-xmark"></i> Cancelar
                                                </a>
                                            <?php endif; ?>

                                            <?php if($budges): ?>
                                                <strong class="badge bg-warning">Aguardando envio</strong>
                                            <?php else: ?>
                                                <?php if(!$btnOptions && !$btnCancel): ?>
                                                    Atualizado
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">   
                                            <?php if($budges || $btnCancel || $btnOptions): ?>
                                                <?php 
                                                    $penalty = verify_penalty($paymentsPending->create_at);
                                                    if($penalty):  
                                                ?>
                                                        <strong class="badge bg-danger">Multa de <?= $penalty*100 ?>%</strong>
                                                <?php else: ?>
                                                    <strong class="badge bg-success">Sem multa</strong>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                Atualizado
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if($student->historicbeltscount()): ?>
                                                <a href="#" class="btn bg-success"
                                                data-post="<?= url("admin/renewals/students") ?>"
                                                data-action="update_graduation"
                                                data-type_action="approved"
                                                data-type_student="<?= $student->type; ?>"
                                                data-student_id="<?= $student->id; ?>"><i class="fa-solid fa-circle-check"></i> Aprovar</a>
                                                <a href="#" class="btn bg-danger"
                                                data-post="<?= url("admin/renewals/students") ?>"
                                                data-action="update_graduation"
                                                data-type_action="disapprove"
                                                data-type_student="<?= $student->type; ?>"
                                                data-student_id="<?= $student->id; ?>"><i class="fa-sharp fa-solid fa-xmark"></i> Reprovar</a>
                                            <?php else: ?>
                                                atualizado
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= url("/admin/students/{$type}/student/{$student->id}"); ?>" class="btn btn-primary btn-block"><b>Gerênciar</b></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Foto</th>
                                        <th>Nome</th>
                                        <th>Professor</th>
                                        <th>Graduação</th>
                                        <th>Status</th>
                                        <th>Pagamento</th>
                                        <th>Multa</th>
                                        <th>Atualizar Graduação</th>
                                        <th>Opções</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php else: ?>
    <div class="alert alert-info alert-dismissible">
        <h5><i class="icon fas fa-info"></i> Informação!</h5>
        Nenhuma aluno ainda cadastrado
    </div>
<?php endif; ?>