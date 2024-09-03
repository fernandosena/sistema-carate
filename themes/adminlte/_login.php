<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <?= $head; ?>

    <link rel="stylesheet" href="<?= url("/shared/styles/boot.css"); ?>"/>
    <link rel="stylesheet" href="<?= url("/shared/styles/styles.css"); ?>"/>
    <link rel="stylesheet" href="<?= theme("/assets/css/login.css", CONF_VIEW_ADMIN); ?>"/>

    <link rel="icon" type="image/png" href="<?= theme("/assets/images/favicon.png", CONF_VIEW_ADMIN); ?>"/>


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= theme("plugins/fontawesome-free/css/all.min.css", CONF_VIEW_ADMIN); ?>">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= theme("plugins/icheck-bootstrap/icheck-bootstrap.min.css", CONF_VIEW_ADMIN); ?>">
    <link rel="stylesheet" href="<?= url("shared/styles/load.css"); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= theme("dist/css/adminlte.min.css", CONF_VIEW_ADMIN); ?>">
</head>
<body class="hold-transition login-page">

<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <p class="ajax_load_box_title">Aguarde, carregando...</p>
    </div>
</div>

<?= $this->section("content"); ?>

<!-- jQuery -->
<script src="<?= theme("plugins/jquery/jquery.min.js", CONF_VIEW_ADMIN); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?= theme("plugins/bootstrap/js/bootstrap.bundle.min.js", CONF_VIEW_ADMIN); ?>"></script>
<!-- AdminLTE App -->
<script src="<?= theme("dist/js/adminlte.min.js", CONF_VIEW_ADMIN); ?>"></script>
<script src="<?= theme("/assets/js/login.js", CONF_VIEW_ADMIN); ?>"></script>
</body>
</html>
