<?php $this->layout("_theme"); ?>

<div class="al-center"><?= flash(); ?></div>
<article class="auth">
<div class="container-tap">

<div class="content-tap">
    <input type="radio" name="slider" checked id="home">
    <input type="radio" name="slider" id="blog">
    <input type="radio" name="slider" id="help">
    <input type="radio" name="slider" id="code">
    <input type="radio" name="slider" id="about">

    <div class="list">
        <label for="home" class="home">
            <span>Certificado</span>
        </label>
        <label for="blog" class="blog">
            <span>Perfil</span>
        </label>
        <label for="help" class="help">
            <span>Histórico</span>
        </label>
        <div class="slider"></div>
    </div>

    <div class="text-content">
        <div class="home text">
            <div class="title">Certificado</div>
            <?php if(!empty($verify)): ?>
                <?php if($student->renewal != "pending"): ?>
                    <p>Seu perfil está pendente para a regularização, clique no botão abaixo para confirmar o pagamento.</p>
                    <a href="#" class="btn bg-success"
                    data-post="<?= url("web/alunos") ?>"
                    data-action="payment"
                    data-student_id="<?= $student->id; ?>"><i class="fa-solid fa-circle-check"></i> confirmar Pagamento</a>
                <?php endif ?>
            <?php endif; ?>
            <?php if(empty($renew)): ?>
                <p>Clique no botão abaixo para gerar o seu certificado</p>
                <a style="text-decoration: none" href="<?= url("certificado/{$document}/certificado") ?>">
                    <button class="auth_form_btn transition gradient gradient-green gradient-hover">Gerar certificado</button>
                </a>
            <?php endif; ?>
        </div>
        <div class="blog text">
            <div class="title">Perfil</div>
            <form class="auth_form" method="post">
                <?= csrf_input(); ?>
                <div class="label_group_div">
                    <label>
                        <div><span class="icon-user">Nome:</span></div>
                        <input type="email" name="email" value="<?= $user->first_name ?>" readonly>
                    </label>
                    <label>
                        <div><span class="icon-user">Sobrenome:</span></div>
                        <input type="email" name="email" value="<?= $user->last_name ?>" readonly>
                    </label>
                </div>
                <label>
                    <div><span class="icon-envelope">E-mail:</span></div>
                    <input type="email" name="email" value="<?= $user->email ?>" readonly>
                </label>
                <div class="label_group_div">
                    <label>
                        <div><span class="icon-bird">Data de nascimento:</span></div>
                        <input type="date" name="date" value="<?= $user->datebirth ?>" readonly>
                    </label>
                    <label>
                        <div><span class="icon-bird">Dojo:</span></div>
                        <input type="text" name="date" value="<?= $user->dojo ?>" readonly>
                    </label>
                </div>
                <label>
                    <div><span class="icon-bird">Documento:</span></div>
                    <input type="text" name="document" value="<?= $user->document ?>" readonly>
                </label>
                <div class="label_group_div">
                    <label>
                        <div><span class="icon-user">CEP:</span></div>
                        <input type="text" name="cep" value="<?= $user->zip ?>" readonly>
                    </label>
                    <label>
                        <div><span class="icon-user">Estado:</span></div>
                        <input type="text" name="email" value="<?= $user->state ?>" readonly>
                    </label>
                </div>
                <div class="label_group_div">
                    <label>
                        <div><span class="icon-user">Cidade:</span></div>
                        <input type="text" name="cep" value="<?= $user->city ?>" readonly>
                    </label>
                    <label>
                        <div><span class="icon-user">Endereço:</span></div>
                        <input type="text" name="email" value="<?= $user->address ?>" readonly>
                    </label>
                </div>
                <div class="label_group_div">
                    <label>
                        <div><span class="icon-user">Complemento:</span></div>
                        <input type="text" name="cep" value="<?= $user->complement ?>" readonly>
                    </label>
                    <label>
                        <div><span class="icon-user">Telefone:</span></div>
                        <input type="text" name="email" value="<?= $user->phone ?>" readonly>
                    </label>
                </div>
                <div class="label_group_div">
                    <label>
                        <div><span class="icon-user">Graduação:</span></div>
                        <input type="text" name="cep" value="<?= $user->belt()->title ?>" readonly>
                    </label>
                    <label>
                        <div><span class="icon-user">Descrição:</span></div>
                        <input type="text" name="email" value="<?= $user->description ?>" readonly>
                    </label>
                </div>
            </form>
        </div>
        <div class="help text">
            <ul class="timeline">
            <?php if(!empty($student)): ?>
                <?php $c=0; foreach($student->historic() as $historic):?>
                    <?php  if($historic->status == "approved" && $c == 0){$c = 1;} ?>
                    <li <?= ($c == 1) ? 'class="active"': null?>>
                        <?php $data = $historic->findBelt($historic->graduation_id) ?>
                        <h6><?= $data->title ?><?= ($historic->status == "pending") ? " - <span class='badge bg-warning'>Em Análise</span>" : (($historic->status == "disapprove") ? " - <span class='badge bg-danger'>Reprovado</span>" : null) ; ?></h6>
                        <p class="mb-0 text-muted"><?= $historic->description ?></p>
                        <o class="text-muted"><?= date_fmt($historic->created_at, "d/m/y \à\s H\hi"); ?></p>
                    </li>
                <?php if($c == 1){$c = 2;} endforeach; ?>
            <?php else: ?>
                <div class="message info icon-warning alert alert-warning alert-dismissible">Nenhum histórico encontrado</div>
            <?php endif; ?>
        </ul>
        </div>
    </div>
</div>
</div>
</article>