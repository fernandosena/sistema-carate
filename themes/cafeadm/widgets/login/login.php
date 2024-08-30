<?php $this->layout("_login"); ?>

<div class="login">
    <article class="login_box radius">
        <h1 class="hl icon-user">Login</h1>
        <div class="ajax_response"><?= flash(); ?></div>

        <form name="login" action="<?= url("/admin/login"); ?>" method="post">
            <label>
                <span class="field icon-envelope">E-mail:</span>
                <input name="email" type="email" placeholder="Informe seu e-mail" required/>
            </label>

            <label>
                <span class="field icon-unlock-alt">Senha:</span>
                <input name="password" type="password" placeholder="Informe sua senha:" required/>
            </label>

            <button class="radius gradient gradient-green gradient-hover icon-sign-in">Entrar</button>
        </form>

        <footer>
            <p>&copy; <?= date("Y"); ?> - todos os direitos reservados</p>
        </footer>
    </article>
</div>