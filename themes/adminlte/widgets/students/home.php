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

    <div class="list-box">
        <?php foreach ($students as $student):
            $studentPhoto = ($student->photo() ? image($student->photo, 300, 300) :
                theme("/assets/images/avatar.jpg", CONF_VIEW_ADMIN));
            ?>
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="<?= $studentPhoto; ?>" alt="<?= $student->fullName(); ?>">
                    </div>
                    <h3 class="profile-username text-center"><?= $student->fullName(); ?></h3>
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
                </div>
            </div>
        <?php endforeach; ?>
        <?= $paginator; ?>
    </div>
<?php else: ?>
    <div class="alert alert-info alert-dismissible">
        <h5><i class="icon fas fa-info"></i> Informação!</h5>
        Nenhuma aluno ainda cadastrado
    </div>
<?php endif; ?>