<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
        <meta name="mit" content="2023-12-17T11:24:10-03:00+198168">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <?= $head; ?>

    <link rel="icon" type="image/png" href="<?= theme("/assets/images/favicon.png"); ?>"/>
    <link rel="stylesheet" href="<?= theme("/assets/style.css"); ?>"/>
</head>
<body>

<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <p class="ajax_load_box_title">Aguarde, carregando...</p>
    </div>
</div>

<!--HEADER-->
<header class="main_header gradient gradient-green">
    <div class="container">
        <?php if(empty($document)): ?>
            <div class="main_header_logo">
                <div class="app-logo">
                    <img src="<?= (conf()->logo) ? image(conf()->logo, 300, 300) : theme("dist/img/AdminLTELogo.png", CONF_VIEW_ADMIN) ?>" alt="<?= CONF_SITE_NAME ?> Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <h1><a class="transition" href="<?= url("/app"); ?>" title="<?= conf()->title ?? CONF_SITE_NAME ?>"><?= conf()->title ?? CONF_SITE_NAME ?></a></h1>
                </div>
            </div>

            <nav class="main_header_nav">
                <span class="main_header_nav_mobile j_menu_mobile_open icon-menu icon-notext radius transition"></span>
                <div class="main_header_nav_links j_menu_mobile_tab">
                    <span class="main_header_nav_mobile_close j_menu_mobile_close icon-error icon-notext transition"></span>
                    <?php if (\Source\Models\Auth::user()): ?>
                        <a class="link login transition radius icon-coffee" title="Controlar"
                        href="<?= url("/app"); ?>">Controlar</a>
                    <?php else: ?>
                        <a class="link login transition radius icon-sign-in" title="Entrar"
                        href="<?= url("/entrar"); ?>">Entrar</a>
                    <?php endif; ?>
                </div>
            </nav>
        <?php endif; ?>
    </div>
</header>

<!--CONTENT-->
<main class="main_content">
    <?= $this->section("content"); ?>
</main>

<?php if ($this->section("optout")): ?>
    <?= $this->section("optout"); ?>
<?php endif; ?>

<!--FOOTER-->
<footer class="main_footer">
    <div class="container content">
        <section class="main_footer_content">
            <article class="main_footer_content_item">
                <h2>Sobre:</h2>
                <p>O <?= CONF_SITE_NAME ?> é um gerenciador de contas simples, poderoso e gratuito.</p>
            </article>

            <article class="main_footer_content_item">
                <h2>Mais:</h2>
                <a class="link transition radius" title="Home" href="<?= url(); ?>">Home</a>
            </article>

            <article class="main_footer_content_item">
                <h2>Contato:</h2>
                <p class="icon-phone"><b>Telefone:</b><br> +55 55 5555.5555</p>
                <p class="icon-envelope"><b>Email:</b><br> sac@<?= CONF_SITE_DOMAIN ?></p>
                <p class="icon-map-marker"><b>Endereço:</b><br> Fpolis, SC/Brasil</p>
            </article>

            <article class="main_footer_content_item social">
                <h2>Social:</h2>
                <a target="_blank" class="icon-facebook"
                   href="https://www.facebook.com/<?= CONF_SOCIAL_FACEBOOK_PAGE; ?>" title="<?= CONF_SITE_NAME ?> no Facebook">/<?= CONF_SITE_NAME ?></a>
                <a target="_blank" class="icon-instagram"
                   href="https://www.instagram.com/<?= CONF_SOCIAL_INSTAGRAM_PAGE; ?>" title="<?= CONF_SITE_NAME ?> no Instagram">@<?= CONF_SITE_NAME ?></a>
                <a target="_blank" class="icon-youtube" href="https://www.youtube.com/<?= CONF_SOCIAL_YOUTUBE_PAGE; ?>"
                   title="<?= CONF_SITE_NAME ?> no YouTube">/<?= CONF_SITE_NAME ?></a>
            </article>
        </section>
    </div>
</footer>
<script src="<?= theme("/assets/scripts.js"); ?>"></script>
<?= $this->section("scripts"); ?>

</body>
</html>