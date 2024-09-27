<?php $this->layout("_admin"); ?>
<?php if(!empty($students)): ?>
    <div class="mb-4">
        <form action="<?= url() ?>" method="post">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="form-group">
                        <div class="input-group input-group-lg">
                            <input type="search" name="s" class="form-control form-control-lg" placeholder="Digite sua pesquisa aqui">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-lg btn-primary">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Bordered Table</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Qtd. de alunos</th>
                        <th>Desde</th>
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
                                <img class="profile-user-img img-fluid img-circle" src="<?= $studentPhoto; ?>" alt="<?= $student->fullName(); ?>">
                            </td>
                            <td><h3 class="profile-username text-center"><?= $student->fullName(); ?></h3></td>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Graduação</b> 
                                    <span class="float-right badge"><?= $student->belt()->title ?></span>
                                </li>
                                <li class="list-group-item">
                                    <b>Status</b> 
                                    <span class="float-right"><strong class="badge bg-<?= ($student->status == 'activated') ? 'success': (($student->status == 'pending') ? 'warning' : 'danger') ?>"><?= ($student->status == 'activated') ? 'Ativo': (($student->status == 'pending') ? 'Pendente' : 'Desativado') ?></strong></span>
                                </li>
                                <li class="list-group-item">
                                    <b>Professor</b> <a href="<?= url("/admin/instructors/instructor/{$student->user_id}") ?>" class="float-right"><?= str_limit_chars($student->teacher()->fullName(), 12)?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Desde</b> <a class="float-right"><?= date_fmt($student->created_at, "d/m/y \à\s H\hi"); ?></a>
                                </li>
                            </ul>
                            <a href="<?= url("/admin/students/{$type}/student/{$student->id}"); ?>" class="btn btn-primary btn-block"><b>Gerênciar</b></a>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            <?= $paginator; ?>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info alert-dismissible">
        <h5><i class="icon fas fa-info"></i> Informação!</h5>
        Nenhuma aluno ainda cadastrado
    </div>
<?php endif; ?>