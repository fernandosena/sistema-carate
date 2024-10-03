<?php $this->layout("_admin"); ?>
<?php if(!empty($students)): ?>
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
                                        <th>CPF</th>
                                        <th>Pagamento</th>
                                        <th>Multa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $student): ?>
                                        <?php 
                                            $renewal_data = verify_renewal_data($student->renewal, $student->last_renewal_data);
                                            if($renewal_data):
                                        ?>
                                        <tr>
                                            <td><a href="<?= url("admin/students/$student->type/student/{$student->id}") ?>"><?= $student->fullName(); ?></a></td>
                                            <td><a href="<?= url("admin/instructors/instructor/{$student->user_id}") ?>"><?= $student->teacher()->fullName() ?></a></td>
                                            <td><?= $student->document ?> </td>
                                                <?php if($student->renewal == "pending"): ?>
                                                    <a href="#" class="btn bg-success"
                                                    data-postbtn="<?= url("admin/students/$student->type/student") ?>"
                                                    data-action="payment"
                                                    data-user_id="<?= user()->id; ?>"
                                                    data-student_id="<?= $student->id; ?>"><i class="fa-solid fa-circle-check"></i> Aprovar</a>
                                                <?php elseif($student->renewal == "approved"):  ?>
                                                    <strong class="badge bg-success">Pagamento realizado</strong>
                                                <?php else: ?>
                                                    <strong class="badge bg-warning">Aguardando envio</strong>
                                                <?php endif; ?>
                                                <th>
                                                    <?php 
                                                        $multa = verify_multa_renewal_data($student->renewal, $student->last_renewal_data);
                                                        if(!empty($multa)){
                                                            ?>
                                                                <strong class="badge bg-danger">
                                                                    <?php 
                                                                        $multa = $multa *100;
                                                                        echo "Multa de {$multa}%";
                                                                    ?>
                                                                </strong>
                                                            <?php
                                                        }else{
                                                            ?>
                                                                <strong class="badge bg-success">Sem multa</strong>
                                                            <?php
                                                        }
                                                    ?>
                                                </th>
                                        </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Professor</th>
                                        <th>CPF</th>
                                        <th>Pagamento</th>
                                        <th>Multa</th>
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