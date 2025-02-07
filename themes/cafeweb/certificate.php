<?php $this->layout("_theme"); ?>

<div class="al-center"><?= flash(); ?></div>
<article class="auth">
    <div class="auth_content container content">
        <header class="auth_header">
            <h1>Bem-vindo karate-ka!</h1>
            <p style="width: 600px; margin:20px auto 0 auto">Aceda aos dados do seu perfil, ao seu certificado de Membro IOGKF Brasil e ao seu histórico de graduações.
Aproveite e coloque a sua foto no perfil.
Se verificar que algum dado do seu perfil se encontra errado, por favor fale com o seu Sensei.

</p>
        </header>

        <form class="auth_form" data-reset="true" action="<?= url("/certificado"); ?>" method="post">

            <div class="ajax_response"><?= flash(); ?></div>
            <?= csrf_input(); ?>

            <label>
                <div style="margin-bottom: 0px">
                    <span class="icon-briefcase">CPF:</span>
                </div>
                <small style="font-size: 13px;" >Obs.: Se você é menor de idade insira o CPF do seu responsável de educação.</small><br><br>
                <input type="text" class="mask-doc" name="document" placeholder="Informe seu CPF:" required/>
            </label>

            <button class="auth_form_btn transition gradient gradient-green gradient-hover">Consultar</button>
        </form>
    </div>
</article>