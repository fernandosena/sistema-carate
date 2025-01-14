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
                <?php 
                $budges = false;
                $btnOptions = false;
                $btnCancel = false;
                $lastPayment = $user->paymentsPendingLast();
                //Verifica se existe um ultimo pagamento (oportunidade para cancelar)
                $paymentsActivatedLast = $user->paymentsActivatedLast();
                if(!$lastPayment){
                    if($paymentsActivatedLast){
                        $budges = verify_renew($paymentsActivatedLast->created_at);
                        $multa = verify_penalty($paymentsActivatedLast->created_at);
                    }else{
                        $budges = verify_renew($user->created_at);
                        $multa = verify_penalty($paymentsActivatedLast->created_at);
                    }
                    if($budges){
                        $btnOptions = true;
                    }
                }else{
                    $dataPayment = new DateTime($lastPayment->created_at);
                    $now = new DateTime();
                    $diferenca = $now->diff($dataPayment);

                    if($diferenca->days <= 0){
                        $btnCancel = true;
                    }
                }
            ?>
            <?php if($multa && $btnOptions || $btnCancel): ?>
                <p>Seu perfil está pendente para a regularização da filiação.</p>
            <?php else: ?>
                <p>Clique no botão abaixo para gerar o seu certificado</p>
                <a style="text-decoration: none" href="<?= url("certificado/{$document}/certificado/{$user->id}") ?>">
                    <button class="auth_form_btn transition gradient gradient-green gradient-hover">Gerar certificado</button>
                </a>
            <?php endif; ?>
        </div>
        <div class="blog text">
            <div class="title">Perfil</div>
            <div>
                <form class="auth_form app_form" action="<?= url("/profile") ?>" method="post">
                    <?= csrf_input(); ?>
                    <input type="hidden" name="document" value="<?= $user->document ?>">
                    <input type="hidden" name="user" value="<?= $user->id ?>">
                    <?php
                        $photo = ($user->photo() ? image($user->photo, 300, 300) :
                        theme("/assets/images/avatar.jpg", CONF_VIEW_ADMIN));
                    ?>
                    <div class="app_formbox_photo">
                        <div class="rounded j_profile_image thumb" style="background-image: url('<?= $photo; ?>')"></div>
                        <div><input data-image=".j_profile_image" type="file" required class="radius"  name="photo"/></div>
                    </div>
                    <button class="auth_form_btn transition gradient gradient-green gradient-hover">Alterar imagem</button>
                </form>
                <div class="auth_form" style="margin-top: 50px">
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
                </div>
            </div>
        </div>
        <div class="help text">
            <ul class="timeline">
            <?php if(!empty($user)): ?>
                <?php $c=0; foreach($user->historic() as $historic):?>
                    <?php if($historic->status == "disapprove"){continue;} ?>
                    <?php  if($historic->status == "approved" && $c == 0){$c = 1;} ?>
                    <li <?= ($c == 1) ? 'class="active"': null?>>
                        <?php $data = $historic->findBelt($historic->graduation_id) ?>
                        <h6><?= $data->title ?><?= ($historic->status == "pending") ? " - <span class='badge bg-warning'>Em Análise</span>" : (($historic->status == "disapprove") ? " - <span class='badge bg-danger'>Reprovado</span>" : null) ; ?></h6>
                        <p class="mb-0 text-muted"><?= $historic->description ?></p>
                        <p class="text-muted"><?= (!empty($historic->date)) ? date_fmt($historic->date, "d/m/Y") : date_fmt($historic->created_at, "d/m/Y"); ?></p>
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