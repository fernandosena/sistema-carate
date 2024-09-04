<?php $this->layout("_admin"); ?>
<div class="list-box">
    <?php foreach ($users as $user):
        $userPhoto = ($user->photo() ? image($user->photo, 300, 300) :
            theme("/assets/images/avatar.jpg", CONF_VIEW_ADMIN));
        ?>
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="<?= $userPhoto; ?>" alt="<?= $user->fullName(); ?>">
                </div>
                <h3 class="profile-username text-center"><?= $user->fullName(); ?></h3>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Qtd. de alunos</b> <a class="float-right"><?= $user->student()["activated"]; ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Desde</b> <a class="float-right"><?= date_fmt($user->created_at, "d/m/y \à\s H\hi"); ?></a>
                    </li>
                </ul>
                <a href="<?= url("/admin/users/user/{$user->id}"); ?>" class="btn btn-primary btn-block"><b>Gerênciar</b></a>
            </div>
        </div>
    <?php endforeach; ?>
    <?= $paginator; ?>
</div>