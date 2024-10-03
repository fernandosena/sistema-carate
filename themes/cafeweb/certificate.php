<?php $this->layout("_theme"); ?>

<div class="al-center"><?= flash(); ?></div>
<article class="auth">
    <div class="auth_content container content">
        <header class="auth_header">
            <h1>Certificado</h1>
            <p>Consulte e faça o download do seu certificado.</p>
        </header>

        <form class="auth_form" data-reset="true" action="<?= url("/certificado"); ?>" method="post">

            <div class="ajax_response"><?= flash(); ?></div>
            <?= csrf_input(); ?>

            <label>
                <div>
                    <span class="icon-briefcase">CPF:</span>
                </div>
                <input type="text" class="mask-doc" name="document" placeholder="Informe seu CPF:" required/>
            </label>

            <button class="auth_form_btn transition gradient gradient-green gradient-hover">Consultar</button>
        </form>
    </div>
</article>