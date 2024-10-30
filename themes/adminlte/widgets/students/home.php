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
                                        <th>Nome</th>
                                        <th>Qtd. de alunos</th>
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
                                        <td><h3 class="profile-username text-center"><?= $student->fullName(); ?></h3></td>
                                        <td>
                                        <a href="<?= url("/admin/students/{$type}/student/{$student->id}"); ?>" class="btn btn-primary btn-block"><b>Gerênciar</b></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Qtd. de alunos</th>
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