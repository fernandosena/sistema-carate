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
            <?php if(!empty($renew)): ?>
                <p>Seu perfil está pendente para a regularização, clique no botão abaixo para confirmar o pagamento.</p>
                <a href="#" class="btn bg-success"
                data-post="<?= url("web/alunos") ?>"
                data-action="payment"
                data-student_id="<?= $student->id; ?>"><i class="fa-solid fa-circle-check"></i> confirmar Pagamento</a>
            <?php else: ?>
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
                <label>
                    <div><span class="icon-envelope">E-mail:</span></div>
                    <input type="email" name="email" value="" readonly>
                </label>
            </form>
        </div>
        <div class="help text">
            <div class="title">Help</div>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio, laborum? Dolorem voluptates modi porro magni dicta, id minus commodi mollitia saepe unde, iure omnis culpa, praesentium dolorum debitis reiciendis impedit veritatis hic cum reprehenderit assumenda possimus temporibus. Nemo sint cum soluta vitae odit tempore ipsum similique, consectetur quos veritatis voluptatibus.</p>
        </div>
    </div>
</div>
</div>
</article>