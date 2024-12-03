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
                                        <td><?= $student->fullName(); ?></td>
                                        <td><?= $student->teacher()->first_name; ?></td>
                                        <td><?= $student->belt()->title; ?></td>
                                        <td><?php if($student->status == "activated"){
                                            echo "<strong class='badge bg-success'>Ativado</strong>";
                                        }else if($student->status == "deactivated"){
                                            echo "<strong class='badge bg-danger'>Desativado</strong>";
                                        }else{

                                            echo "<strong class='badge bg-warning'>Pendente</strong>";
                                        } ?></td>
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