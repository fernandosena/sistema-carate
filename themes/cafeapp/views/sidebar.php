<div class="app_sidebar_nav">
    <a class="icon-home radius transition" title="Dashboard" href="<?= url("/app"); ?>">Controle</a>
    <a class="icon-home radius transition" title="Pagamentos" href="<?= url("/app/pagamentos"); ?>">Pagamentos</a>
    <a class="icon-bookmark-o radius transition certificado" target="__blank" title="Certificado" href="<?= url("certificado/".user()->document."/certificado/".user()->id); ?>">Meu Certificado</a>
    <a class="icon-user radius transition" title="Alunos Dan" href="<?= url("/app/alunos/black"); ?>">Alunos Dan</a>
    <a class="icon-user radius transition" title="Alunos Kyus" href="<?= url("/app/alunos/kyus"); ?>">Alunos Kyus</a>
    <a class="icon-user radius transition" title="Perfil" href="<?= url("/app/perfil"); ?>">Perfil</a>
    <span class="icon-life-ring radius transition" data-modalopen=".app_modal_contact">Suporte</span>
    <a class="icon-sign-out radius transition" title="Sair" href="<?= url("/app/sair"); ?>">Sair</a>
</div>