<?php $this->layout("_theme"); 

use Source\Models\App\AppTransfers;?>
<?php $this->start('style') ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<?php $this->stop() ?>

<section class="my-5 info-student">
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <?php
                                    $userPhoto = ($student->photo() ? image($student->photo, 300, 300) :
                                    theme("/assets/images/avatar.jpg", CONF_VIEW_ADMIN));
                                ?>
                                <img src="<?= $userPhoto ?>" alt="<?= $student->fullName() ?>"
                                    class="rounded-circle p-1 bg-warning" width="110">
                                <div class="mt-3">
                                    <h4><?= $student->fullName() ?></h4>
                                    <p>Cadastro: <?= date_fmt($student->created_at, "d/m/y \à\s H\hi"); ?></p>

                                    <p>Endereço: <?= $student->address ?>, <?= $student->number ?> <?= $student->complement ?>, <?= $student->city ?> - <?= $student->state ?> - <?= $student->zip ?></p>
                                </div>
                            </div>
                            <div class="list-group list-group-flush text-center mt-4">
                                <a href="#" class="btn btn-primary btn-block" data-modalopen="<?= (!empty($type) && $type == "black") ? '.app_modal_student' : '.app_modal_student_kyus' ; ?>">
                                    Editar Dados
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="top-status">
                                <h5>Graduação</h5>
                                <ul>
                                    <li style="overflow: hidden;">
                                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                                        width="1280.000000pt" height="801.000000pt" viewBox="0 0 1080.000000 801.000000"
                                        preserveAspectRatio="xMidYMid meet">
                                        <g transform="translate(0.000000,801.000000) scale(0.08,-0.08)"
                                        fill="<?= $student->belt()->color ?>" stroke="none">
                                        <path d="M9365 7982 c-144 -52 -384 -164 -725 -335 l-335 -169 -55 13 -55 14
                                        -7 73 c-10 95 -29 133 -81 163 -41 23 -47 24 -247 22 -113 -1 -369 -6 -570
                                        -11 -401 -11 -440 -16 -505 -73 -35 -32 -50 -64 -60 -139 l-7 -46 -106 13
                                        c-229 27 -410 57 -491 80 -48 13 -105 28 -129 33 -139 30 -1325 47 -3973 56
                                        l-1989 7 0 -727 0 -728 2448 6 c1346 3 2532 9 2636 12 103 3 187 2 185 -3 -2
                                        -4 -50 -84 -105 -178 -352 -590 -613 -1138 -694 -1456 -20 -76 -21 -118 -25
                                        -952 -4 -848 -9 -1221 -40 -2836 -9 -426 -14 -775 -12 -777 1 -2 343 -6 759
                                        -10 l756 -7 7 1289 c7 1215 -7 4044 -21 4289 l-6 100 188 160 c242 206 370
                                        310 519 423 l119 91 28 -52 c47 -87 97 -124 269 -199 85 -37 237 -104 339
                                        -149 415 -183 706 -285 878 -309 138 -19 204 13 217 105 8 48 2 136 -10 167
                                        -6 15 2 14 57 -8 94 -37 235 -79 401 -119 l148 -36 45 21 c56 28 141 127 214
                                        250 l53 90 250 0 250 0 -7 -402 c-3 -222 -11 -594 -16 -828 -5 -234 -14 -634
                                        -20 -890 -6 -256 -17 -733 -25 -1060 -8 -327 -20 -779 -25 -1005 -6 -225 -15
                                        -592 -21 -814 -8 -330 -8 -406 3 -412 7 -5 333 -9 724 -9 l712 0 7 1118 c5
                                        637 3 1801 -3 2707 -5 875 -8 1592 -5 1595 2 2 348 6 768 8 l763 4 6 132 c7
                                        177 28 1397 24 1401 -2 2 -553 7 -1223 11 l-1220 6 -180 88 c-293 143 -476
                                        207 -620 216 -71 4 -89 2 -160 -24z"/>
                                        </g>
                                        </svg>
                                        <span><?= $student->belt()->title ?></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="list-group list-group-flush text-center mt-4">
                                <?php 
                                    $trsnfer = (new AppTransfers())->find("id_of = :of AND student_id = :id AND status = 'pending'", "of=".(user()->id)."&id={$student->id}")->fetch();

                                    if($trsnfer):
                                ?>
                                <a href="#"
                                    data-post="<?= url("app/transfer") ?>"
                                    data-action="cancel"
                                    data-student_id="<?= $student->id; ?>"><button  class="btn bg-danger"><i class="fa-solid fa-circle-check"></i> Cancelar Transferência</button></a>
                                <?php else: ?>

                                <a href="#"
                                data-modalopen=".app_modal_student_transfer"><button  class="btn bg-success"><i class="fa-solid fa-circle-check"></i> Tranferir Aluno</button></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-body p-0 table-responsive">
                            <h4 class="p-3 mb-0">Informações</h4>
                            <ul class="card-body informacoes-card">
                                <?php if(!empty($student->email)): ?>
                                <li><span>E-mail:</span></span><?= $student->email ?></span></li>
                                <?php endif; ?>
                                <?php if(!empty($student->mother_name)): ?>
                                <li><span>Nome responsável:</span></span><?= $student->mother_name ?></span></li>
                                <?php endif; ?>
                                <li><span>Data de nascimento:</span></span><?= date("d/m/Y", strtotime($student->datebirth)) ?></span></li>
                                <li><span>CPF:</span></span><?= $student->document ?></span></li>
                                <li><span>Telefone:</span></span><?= $student->phone ?></span></li>
                                <li><span>Dojo:</span></span><?= $student->dojo ?></span></li>
                                <li>
                                <span>Status:</span>
                                <span>
                                    <strong class="badge bg-<?= ($student->status == 'activated') ? 'success': (($student->status == 'pending') ? 'warning' : 'danger') ?>"><?= ($student->status == 'activated') ? 'Ativo': (($student->status == 'pending') ? 'Pendente' : 'Desativado') ?></strong>
                                </span>
                                </li>
                                <li><span>Descrição:</span></span><?= $student->description ?></span></li>
                                <li>
                            </ul>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-body">
                            <h4>Trajetória de graduação</h4>
                            <ul class="timeline">
                                <?php $c=0; foreach($student->historic() as $historic):?>
                                    <?php  if($historic->status == "approved" && $c == 0){$c = 1;} ?>
                                    <li <?= ($c == 1) ? 'class="active"': null?>>
                                        <?php $data = $historic->findBelt($historic->graduation_id) ?>
                                        <h6><?= $data->title ?><?= ($historic->status == "pending") ? " - <span class='badge bg-warning'>Em Análise</span>" : (($historic->status == "disapprove") ? " - <span class='badge bg-danger'>Reprovado</span>" : null) ; ?></h6>
                                        <o class="text-muted"><?= date_fmt($historic->graduation_data, "d/m/y"); ?></p>
                                    </li>
                                <?php if($c == 1){$c = 2;} endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->start('scripts') ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<?php $this->stop() ?>
