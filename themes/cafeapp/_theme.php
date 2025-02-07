<?php 
    // Verifica se já existe o cookie 'pages' e decodifica
    if (isset($_COOKIE['pages2'])) {
        $pages = json_decode($_COOKIE['pages'], true);
    } else {
        $pages = [];
    }

    // Adiciona a URL da página atual
    $currentUrl = $_SERVER['REQUEST_URI'];
    if (!in_array($currentUrl, $pages)) {
        // Adiciona a nova página ao array
        array_unshift($pages, $currentUrl); // Adiciona ao início para que o último seja o anterior
        // Limita o número de URLs armazenadas a um número máximo (por exemplo, 10)
        if (count($pages) > 10) {
            array_pop($pages); // Remove a página mais antiga se exceder o limite
        }
        // Atualiza o cookie com a lista de páginas
        setcookie('pages2', json_encode($pages), time() + 3600*24, '/'); // O cookie dura 24 hora
    }else{
        $pages = array_diff($pages, [$currentUrl]);
        array_unshift($pages, $currentUrl);
        // Atualiza o cookie com a lista de páginas
        setcookie('pages2', json_encode($pages), time() + 3600*24, '/'); // O cookie dura 24 hora
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <?= $head; ?>
    <?=$this->section('style')?>

    <link rel="stylesheet" href="<?= theme("/assets/style.css", CONF_VIEW_APP); ?>"/>
    <link rel="icon" type="image/png" href="<?= theme("/assets/images/favicon.png", CONF_VIEW_APP); ?>"/>
</head>
<body>

<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <p class="ajax_load_box_title">Aguarde, carregando...</p>
    </div>
</div>

<div class="app">
    <header class="app_header">
        <div class="app-logo">
            <img src="<?= (conf()->logo) ? image(conf()->logo, 300, 300) : theme("dist/img/AdminLTELogo.png", CONF_VIEW_ADMIN) ?>" alt="<?= CONF_SITE_NAME ?> Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <h1><a class="transition" href="<?= url("/app"); ?>" title="<?= conf()->title ?? CONF_SITE_NAME ?>"><?= conf()->title ?? CONF_SITE_NAME ?></a></h1>
        </div>
        <ul class="app_header_widget">
            <li data-mobilemenu="open" class="app_header_widget_mobile radius transition icon-menu icon-notext"></li>
        </ul>
    </header>

    <div class="app_box">
        <nav class="app_sidebar radius box-shadow">
            <div data-mobilemenu="close"
                 class="app_sidebar_widget_mobile radius transition icon-error icon-notext"></div>

            <div class="app_sidebar_user app_widget_title">
                <span class="user">
                    <?php if (user()->photo()): ?>
                        <img class="rounded" alt="<?= user()->first_name; ?>" title="<?= user()->first_name; ?>"
                             src="<?= image(user()->photo, 260, 260); ?>"/>
                    <?php else: ?>
                        <img class="rounded" alt="<?= user()->first_name; ?>" title="<?= user()->first_name; ?>"
                             src="<?= theme("/assets/images/avatar.jpg", CONF_VIEW_APP); ?>"/>
                    <?php endif; ?>
                    <span><?= user()->first_name; ?></span>
                </span>
            </div>

            <?= $this->insert("views/sidebar"); ?>
        </nav>

        <main class="app_main">
            <div style="text-align: right;margin-bottom: 10px">
                <?php 
                    if (isset($pages)) {
                        if (count($pages) > 1) { // Garante que há uma página anterior
                            $previousPage = $pages[1]; // A página anterior está no índice 0
                            echo "<a href='$previousPage'><- Retornar a página anterior</a>";
                        }
                    }
                ?>
            </div>
            <div class="al-center"><?= flash(); ?></div>
            <?= $this->section("content"); ?>
        </main>
    </div>

    <footer class="app_footer">
        <span class="icon-cog">
            <?= CONF_SITE_NAME ?><br>
            &copy; Todos os direitos reservados
        </span>
    </footer>

    <?= $this->insert("views/modals"); ?>
</div>
<script src="<?= theme("/assets/scripts.js", CONF_VIEW_APP); ?>"></script>
<?= $this->section("scripts"); ?>

</body>
</html>