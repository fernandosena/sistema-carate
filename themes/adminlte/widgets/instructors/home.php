<?php $this->layout("_admin"); ?>
<?php if(!empty($users)): ?> 
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lista de instrutores</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Foto</th>
                                        <th>Nome</th>
                                        <th>Qtd. de alunos</th>
                                        <th>Pagamento</th>
                                        <th>Multa</th>
                                        <th>Atualizar Graduação</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user):
                                            $userPhoto = ($user->photo() ? image($user->photo, 100, 100) :
                                            theme("/assets/images/avatar.jpg", CONF_VIEW_ADMIN));
                                    
                                            //Verifica se existe algum pagamento pendente
                                            $verify = false;
                                            $btnOptions = false;
                                            $btnCancel = false;
                                            $budges = false;
                                            $paymentsPending = $user->paymentsPendingLast();
                                            //Verifica se existe um ultimo pagamento (oportunidade para cancelar)
                                            $lastPayment = $user->paymentsActivatedLast();

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
                                                    $budges = verify_renew($user->created_at);                                                    
                                                }
                                            }
                                        ?>
                                    <tr>
                                        <td>
                                            <img class="profile-user-img img-fluid img-circle img-table" src="<?= $userPhoto; ?>" alt="<?= $user->fullName(); ?>">
                                        </td>
                                        <td><h3 class="profile-username"><?= $user->fullName(); ?></h3></td>
                                        <td><a class="float-right"><?= $user->student()["all"]; ?></a></td>
                                        
                                        <td class="text-center">
                                            <?php if($btnOptions): ?>
                                                <a href="#" class="btn bg-success"
                                                data-post="<?= url("admin/post/instructor/payment") ?>"
                                                data-type="activated"
                                                data-id="<?= $paymentsPending->id; ?>">
                                                    <i class="fa-solid fa-circle-check"></i> Aprovar
                                                </a>
                                                <a href="#" class="btn bg-danger"
                                                data-post="<?= url("admin/post/instructor/payment") ?>"
                                                data-type="disapprove"
                                                data-id="<?= $paymentsPending->id; ?>">
                                                    <i class="fa-sharp fa-solid fa-xmark"></i> Reprovar
                                                </a>
                                            <?php endif; ?>
                                            
                                            <?php  if($btnCancel): ?>
                                                <a href="#" class="btn bg-danger"
                                                data-post="<?= url("admin/post/instructor/payment") ?>"
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
                                            <?php if($user->historicbeltscount()): ?>
                                                <a href="#" class="btn bg-success"
                                                data-post="<?= url("admin/renewals/students") ?>"
                                                data-action="update_graduation"
                                                data-type_action="approved"
                                                data-type_student="<?= $user->type; ?>"
                                                data-student_id="<?= $user->id; ?>"><i class="fa-solid fa-circle-check"></i> Aprovar</a>
                                                <a href="#" class="btn bg-danger"
                                                data-post="<?= url("admin/renewals/students") ?>"
                                                data-action="update_graduation"
                                                data-type_action="disapprove"
                                                data-type_student="<?= $user->type; ?>"
                                                data-student_id="<?= $user->id; ?>"><i class="fa-sharp fa-solid fa-xmark"></i> Reprovar</a>
                                            <?php else: ?>
                                                atualizado
                                            <?php endif; ?>
                                        </td>
                                        <td><a href="<?= url("/admin/instructors/instructor/{$user->id}"); ?>" class="btn btn-primary btn-block"><b>Gerênciar</b></a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Foto</th>
                                        <th>Nome</th>
                                        <th>Qtd. de alunos</th>
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
            Nenhuma instrutor ainda cadastrado
        </div>
    <?php endif; ?>