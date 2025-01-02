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
                                        <td>
                                            <img class="profile-user-img img-fluid img-circle img-table" src="<?= $studentPhoto; ?>" alt="<?= $student->fullName(); ?>">
                                        </td>
                                        <td><?= $student->fullName(); ?> <?= (calcularIdade($student->datebirth) < 13) ? "<strong class='badge bg-warning'>Até 12 anos</strong>": "" ?></td>
                                        <td><?= $student->teacher()->first_name; ?></td>
                                        <td><?= $student->belt()->title; ?></td>
                                        <td><?php if($student->status == "activated"){
                                        ?><a href="#" class="btn bg-warning"
                                            data-postbtn="<?= url("admin/post/students/status") ?>"
                                            data-type="pending"
                                            data-student_id="<?= $student->id; ?>"><i class="fa-solid fa-circle-check"></i> Pendente</a>
                                        <?php
                                        }else{
                                            ?>
                                            <a href="#" class="btn bg-success"
                                            data-postbtn="<?= url("admin/post/students/status") ?>"
                                            data-type="activated"
                                            data-student_id="<?= $student->id; ?>"><i class="fa-solid fa-circle-check"></i> Aprovar</a>
                                            <?php
                                        } ?></td>
                                        <td class="text-center">
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
                                        <td class="text-center">
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