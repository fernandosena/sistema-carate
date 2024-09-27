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
                                        <th>Desde</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user):
                                    $userPhoto = ($user->photo() ? image($user->photo, 100, 100) :
                                        theme("/assets/images/avatar.jpg", CONF_VIEW_ADMIN));
                                    ?>
                                    <tr>
                                        <td>
                                            <img class="profile-user-img img-fluid img-circle img-table" src="<?= $userPhoto; ?>" alt="<?= $user->fullName(); ?>">
                                        </td>
                                        <td><h3 class="profile-username"><?= $user->fullName(); ?></h3></td>
                                        <td><a class="float-right"><?= $user->student()["all"]; ?></a></td>
                                        <td><?= date_fmt($user->created_at, "d/m/y \à\s H\hi"); ?></td>
                                        <td><a href="<?= url("/admin/instructors/instructor/{$user->id}"); ?>" class="btn btn-primary btn-block"><b>Gerênciar</b></a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Foto</th>
                                        <th>Nome</th>
                                        <th>Qtd. de alunos</th>
                                        <th>Desde</th>
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