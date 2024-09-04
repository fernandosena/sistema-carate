<?php $this->layout("_admin"); ?>
<div class="list-box">
    <?php foreach ($students as $student):
        $studentPhoto = ($student->photo() ? image($student->photo, 300, 300) :
            theme("/assets/images/avatar.jpg", CONF_VIEW_ADMIN));
        ?>
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <a href="<?= url("/admin/users/historical/{$student->id}"); ?>">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="<?= $studentPhoto; ?>" alt="<?= $student->fullName(); ?>">
                    </div>
                    <h3 class="profile-username text-center"><?= $student->fullName(); ?></h3>
                </a>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Faixa</b> 
                        <span class="float-right badge" style="background-color: <?= $student->belt()->color ?>
"><?= $student->belt()->title ?></span>
                    </li>
                    <li class="list-group-item">
                        <b>Professor</b> <a href="<?= url("/admin/users/user/{$student->user_id}") ?>" class="float-right"><?= str_limit_chars($student->teacher()->fullName(), 12)?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Desde</b> <a class="float-right"><?= date_fmt($student->created_at, "d/m/y \à\s H\hi"); ?></a>
                    </li>
                </ul>
                <a href="<?= url("/admin/students/student/{$student->id}"); ?>" class="btn btn-primary btn-block"><b>Gerênciar</b></a>
            </div>
        </div>
    <?php endforeach; ?>
    <?= $paginator; ?>
</div>