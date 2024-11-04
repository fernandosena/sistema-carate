<?php $this->layout("_admin"); ?>
<?php if(!empty($students)):?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lista de renovação pendente</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Professor</th>
                                        <th>Graduação</th>
                                        <th>Pagamento</th>
                                        <th>Multa</th>
                                        <th>Atualizar Graduação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $student): ?>
                                        <tr>
                                            <td><a href="<?= url("admin/students/$student->type/student/{$student->id}") ?>"><?= $student->fullName(); ?></a></td>

                                            <?php if(!empty($student->user_id)): ?>
                                                <td><a href="<?= url("admin/instructors/instructor/{$student->user_id}") ?>"><?= $student->teacher()->fullName() ?></a></td>
                                            <?php else: ?>
                                                <td>----------</td>
                                            <?php endif; ?>

                                            <td><?= $student->belt()->title ?> </td>

                                            <td>
                                                <?php 
                                                $last_renewal_data = $student->last_renewal_data;
                                                if(verify_renew($last_renewal_data)): ?>
                                                    <?php if(empty($student->renewal)): ?>
                                                        <strong class="badge bg-warning">Aguardando envio</strong>
                                                    <?php elseif($student->renewal == "approved"): ?>
                                                        <strong class="badge bg-success">Pagamento realizado</strong></strong>
                                                    <?php else: ?>
                                                        <?php if(!empty($student->user_id)): ?>
                                                            <a href="#" class="btn bg-success"
                                                            data-postbtn="<?= url("admin/students/$student->type/student") ?>"
                                                            data-action="payment"
                                                            data-user_id="<?= user(5)->id; ?>"
                                                            data-student_id="<?= $student->id; ?>"><i class="fa-solid fa-circle-check"></i> Aprovar</a>
                                                        <?php else: ?>
                                                            <a href="#" class="btn bg-success"
                                                            data-postbtn="<?= url("admin/instructors/instructor") ?>"
                                                            data-action="payment"
                                                            data-user_id="<?= user(5)->id; ?>"
                                                            data-instruncto_id="<?= $student->id; ?>"><i class="fa-solid fa-circle-check"></i> Aprovar</a>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    atualizado
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    if(verify_renew($last_renewal_data)):
                                                        if(!empty($student->renewal) && ($student->renewal == "pending")){
                                                            $last_renewal_data = $student->renewal_data;
                                                        }
                                                        if(empty($student->renewal)){
                                                            $last_renewal_data=null;
                                                        }

                                                        $verify = verify_penalty($last_renewal_data);
                                                        if($verify):
                                                            $multa = $verify *100;
                                                ?>
                                                        <strong class="badge bg-danger">Multa de <?= $multa ?>%</strong>
                                                    <?php else:?>
                                                        <strong class="badge bg-success">Sem multa</strong>
                                                    <?php endif;?>
                                                <?php else: ?>
                                                    atualizado
                                                <?php endif; ?>
                                            </td>
                                            <td>
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
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Professor</th>
                                        <th>Graduação</th>
                                        <th>Pagamento</th>
                                        <th>Multa</th>
                                        <th>Atualizar Graduação</th>
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
        Nenhuma renovação encontrada
    </div>
<?php endif; ?>