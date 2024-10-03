<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <?= $head; ?>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome" href="/css/app-wa-09b459cf485d4b1f3304947240314c05.css?vsn=d">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-duotone-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-thin.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-regular.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-light.css" >
    <link rel="stylesheet" href="<?= theme("plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css", CONF_VIEW_ADMIN); ?>">
    <link rel="stylesheet" href="<?= theme("plugins/icheck-bootstrap/icheck-bootstrap.min.css", CONF_VIEW_ADMIN); ?>">
    <link rel="stylesheet" href="<?= theme("plugins/select2/css/select2.min.css", CONF_VIEW_ADMIN); ?>">
    <link rel="stylesheet" href="<?= theme("plugins/jqvmap/jqvmap.min.css", CONF_VIEW_ADMIN); ?>">
    <link rel="stylesheet" href="<?= theme("dist/css/adminlte.min.css", CONF_VIEW_ADMIN); ?>">
    <link rel="stylesheet" href="<?= theme("plugins/overlayScrollbars/css/OverlayScrollbars.min.css", CONF_VIEW_ADMIN); ?>">
    <link rel="stylesheet" href="<?= theme("plugins/daterangepicker/daterangepicker.css", CONF_VIEW_ADMIN); ?>">
    <link rel="stylesheet" href="<?= theme("plugins/summernote/summernote-bs4.min.css", CONF_VIEW_ADMIN); ?>">

    <link rel="stylesheet" href="<?= theme("plugins/datatables-bs4/css/dataTables.bootstrap4.min.css", CONF_VIEW_ADMIN); ?>">
    <link rel="stylesheet" href="<?= theme("plugins/datatables-responsive/css/responsive.bootstrap4.min.css", CONF_VIEW_ADMIN); ?>">
    <link rel="stylesheet" href="<?= theme("plugins/datatables-buttons/css/buttons.bootstrap4.min.css", CONF_VIEW_ADMIN); ?>">

    <link rel="stylesheet" href="<?= url("shared/styles/load.css"); ?>">
    <link rel="stylesheet" href="<?= theme("assets/css/style.css", CONF_VIEW_ADMIN); ?>">
</head>
    <body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
        <div class="ajax_load" style="z-index: 999;">
            <div class="ajax_load_box">
                <div class="ajax_load_box_circle"></div>
                <p class="ajax_load_box_title">Aguarde, carregando...</p>
            </div>
        </div>
        <div class="wrapper">
            <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__shake" src="<?= theme("dist/img/AdminLTELogo.png", CONF_VIEW_ADMIN) ?>" alt="<?= CONF_SITE_NAME ?>" height="60" width="60">
            </div>

            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?= url("admin") ?>" class="nav-link">Home</a>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="<?= url("admin/") ?>" class="brand-link">
                <img src="<?= theme("dist/img/AdminLTELogo.png", CONF_VIEW_ADMIN) ?>" alt="<?= CONF_SITE_NAME ?> Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><?= CONF_SITE_NAME ?></span>
                </a>
                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <?php if (user()->photo()): ?>
                                <img class="img-circle elevation-2" alt="<?= user()->first_name; ?>" title="<?= user()->first_name; ?>"
                                        src="<?= image(user()->photo, 260, 260); ?>"/>
                            <?php else: ?>
                                <img class="img-circle elevation-2"  alt="<?= user()->first_name; ?>" title="<?= user()->first_name; ?>"
                                        src="<?= theme("/assets/images/avatar.jpg", CONF_VIEW_ADMIN); ?>"/>
                            <?php endif; ?>
                        </div>
                        <div class="info">
                            <?php $idUser = user()->id; ?>
                            <a href="<?= url("/admin/instructors/instructor/{$idUser}") ?>" class="d-block"><?= str_limit_words(user()->fullName(), 3); ?></a>
                        </div>
                    </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <?php
                            $nav = function ($array) use ($app) {
                                $nav = "";
                                if(is_array($array)){
                                    $ex1 = explode("/", $app);
                                    $ex2 = explode("/", $array['href']);

                                    $activeM = (($ex1[0] == $ex2[0]) && (!empty($ex2[1]) ? ($ex1[1] == $ex2[1]) : false) ? "active" : null);
                                    $urlM = url("/admin/{$array['href']}");

                                    $nav .= "<li class='nav-item ".(!empty($activeM) ? "menu-open" : null )."'>
                                                <a href='{$urlM}' class='nav-link {$activeM}'>
                                                    <i class='nav-icon fas {$array["icon"]}'></i>
                                                    <p>
                                                        {$array['title']}
                                                        ".(!empty($array["submenu"]) ? "
                                                        <i class='right fas fa-angle-left'></i>" : null) ."
                                                    </p>
                                                    ".((!empty($array["badge"]) && !empty($array["badgeText"])) ? "<span class='badge badge-".$array["badge"]." right'>".$array["badgeText"]."</span>" : null)."
                                                </a>";
                                        if(!empty($array["submenu"])){
                                            $nav .= "<ul class='nav nav-treeview'>";
                                            foreach ($array["submenu"] as $submenu) {
                                                $exp1 = explode("/", $app);
                                                $exp2 = explode("/", $submenu['href']);

                                                $activeS = (($exp1[0] == $exp2[0]) && ($exp1[1] == $exp2[1]) && (!empty($exp2[2]) ? ($exp1[2] == $exp2[2]) : true)) ? "active" : null;
                                                $urlS = url("/admin/{$submenu['href']}");

                                                $nav .= "<li class='nav-item'>
                                                            <a class='nav-link {$activeS}' href='{$urlS}'>
                                                                <i class='far {$submenu["icon"]}'></i>
                                                                <p>{$submenu["title"]}</p>
                                                            </a>
                                                        </li>";
                                            }
                                            $nav .= "</ul>";
                                        }
                                    $nav .= "</li>";
                                }
                                return $nav;
                            };

                            echo $nav(
                                [
                                    "icon"=>"fa-tachometer-alt",
                                    "href"=>"dash",
                                    "title"=>"Dashboard",
                                ],
                            );
                            echo '<li class="nav-header">Lista</li>';
                            echo $nav(
                                [
                                    "icon"=>"fa-refresh",
                                    "href"=>"renewals",
                                    "title"=>"Renovações",
                                    "submenu"=> [
                                        [
                                            "icon"=>"fa-refresh",
                                            "href"=>"renewals",
                                            "title"=>"Alunos",
                                        ],
                                        [
                                            "icon"=>"fa-refresh",
                                            "href"=>"renewals",
                                            "title"=>"Instrutores",
                                        ]
                                    ],
                                ],
                            );
                            echo '<li class="nav-header">Gerênciar</li>';
                            echo $nav(
                                [
                                    "icon"=>"fa-chalkboard-teacher",
                                    "href"=>"instructors",
                                    "title"=>"Instrutor",
                                    "submenu"=> [
                                        [
                                            "icon"=>"fa-list",
                                            "href"=>"instructors/home",
                                            "title"=>"Listar",
                                        ],
                                        [
                                            "icon"=>"fa-user-plus",
                                            "href"=>"instructors/instructor",
                                            "title"=>"Cadastrar",
                                        ]
                                    ],
                                ],
                            );
                            echo $nav(
                                [
                                    "icon"=>"fa-graduation-cap",
                                    "href"=>"students/black",
                                    "title"=>"Faixas Preta",
                                    "submenu"=> [
                                        [
                                            "icon"=>"fa-list",
                                            "href"=>"students/black/home",
                                            "title"=>"Listar",
                                        ],
                                        [
                                            "icon"=>"fa-user-plus",
                                            "href"=>"students/black/student",
                                            "title"=>"Cadastrar",
                                        ]
                                    ],
                                ],
                            );
                            echo $nav(
                                [
                                    "icon"=>"fa-graduation-cap",
                                    "href"=>"students/kyus",
                                    "title"=>"Kyus",
                                    "submenu"=> [
                                        [
                                            "icon"=>"fa-list",
                                            "href"=>"students/kyus/home",
                                            "title"=>"Listar",
                                        ],
                                        [
                                            "icon"=>"fa-user-plus",
                                            "href"=>"students/kyus/student",
                                            "title"=>"Cadastrar",
                                        ]
                                    ],
                                ],
                            );
                            echo $nav(
                                [
                                    "icon"=>"fa-uniform-martial-arts",
                                    "href"=>"belts",
                                    "title"=>"Graduações",
                                    "submenu"=> [
                                        [
                                            "icon"=>"fa-list",
                                            "href"=>"belts/home",
                                            "title"=>"Listar",
                                        ],
                                        [
                                            "icon"=>"fa-user-plus",
                                            "href"=>"belts/belt",
                                            "title"=>"Cadastrar",
                                        ]
                                    ],
                                ],
                            );
                            echo '<li class="nav-header">Sistema</li>';
                            echo $nav(
                                [
                                    "icon"=>"fa-sign-out",
                                    "href"=>"logoff",
                                    "title"=>"Sair",
                                ],
                            );
                        ?>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= url("admin") ?>">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="ajax_response"><?= flash(); ?></div>
                    <?= $this->section("content"); ?>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; <?= date('Y')?></strong>
            Todos os direitos reservados.
            <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 0.1.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
        </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="<?= theme("plugins/jquery/jquery.min.js", CONF_VIEW_ADMIN); ?>"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?= theme("plugins/jquery-ui/jquery-ui.min.js", CONF_VIEW_ADMIN); ?>"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

    <script src="<?= url("shared/scripts/jquery.mask.js"); ?>"></script>
    </body>
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?= theme("plugins/bootstrap/js/bootstrap.bundle.min.js", CONF_VIEW_ADMIN); ?>"></script>
    <!-- ChartJS -->
    <script src="<?= theme("plugins/chart.js/Chart.min.js", CONF_VIEW_ADMIN); ?>"></script>
    <!-- Sparkline -->
    <script src="<?= theme("plugins/sparklines/sparkline.js", CONF_VIEW_ADMIN); ?>"></script>
    <!-- JQVMap -->
    <script src="<?= theme("plugins/jqvmap/jquery.vmap.min.js", CONF_VIEW_ADMIN); ?>"></script>
    <script src="<?= theme("plugins/jqvmap/maps/jquery.vmap.usa.js", CONF_VIEW_ADMIN); ?>"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?= theme("plugins/jquery-knob/jquery.knob.min.js", CONF_VIEW_ADMIN); ?>"></script>
    <!-- daterangepicker -->
    <script src="<?= theme("plugins/moment/moment.min.js", CONF_VIEW_ADMIN); ?>"></script>
    <script src="<?= theme("plugins/daterangepicker/daterangepicker.js", CONF_VIEW_ADMIN); ?>"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?= theme("plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js", CONF_VIEW_ADMIN); ?>"></script>
    <!-- Summernote -->
    <script src="<?= theme("plugins/summernote/summernote-bs4.min.js", CONF_VIEW_ADMIN); ?>"></script>

    <script src="<?= theme("plugins/datatables/jquery.dataTables.min.js", CONF_VIEW_ADMIN); ?>"></script>
    <script src="<?= theme("plugins/datatables-bs4/js/dataTables.bootstrap4.min.js", CONF_VIEW_ADMIN); ?>"></script>
    <script src="<?= theme("plugins/datatables-responsive/js/dataTables.responsive.min.js", CONF_VIEW_ADMIN); ?>"></script>
    <script src="<?= theme("plugins/datatables-responsive/js/responsive.bootstrap4.min.js", CONF_VIEW_ADMIN); ?>"></script>
    <script src="<?= theme("plugins/datatables-buttons/js/dataTables.buttons.min.js", CONF_VIEW_ADMIN); ?>"></script>
    <script src="<?= theme("plugins/datatables-buttons/js/buttons.bootstrap4.min.js", CONF_VIEW_ADMIN); ?>"></script>
    <script src="<?= theme("plugins/jszip/jszip.min.js", CONF_VIEW_ADMIN); ?>"></script>
    <script src="<?= theme("plugins/pdfmake/pdfmake.min.js", CONF_VIEW_ADMIN); ?>"></script>
    <script src="<?= theme("plugins/pdfmake/vfs_fonts.js", CONF_VIEW_ADMIN); ?>"></script>
    <script src="<?= theme("plugins/datatables-buttons/js/buttons.html5.min.js", CONF_VIEW_ADMIN); ?>"></script>
    <script src="<?= theme("plugins/datatables-buttons/js/buttons.print.min.js", CONF_VIEW_ADMIN); ?>"></script>
    <script src="<?= theme("plugins/datatables-buttons/js/buttons.colVis.min.js", CONF_VIEW_ADMIN); ?>"></script>

    <!-- overlayScrollbars -->
    <script src="<?= theme("plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js", CONF_VIEW_ADMIN); ?>"></script>
    <script src="<?= url("/shared/scripts/jquery.form.js"); ?>"></script>
    <script src="<?= theme("plugins/select2/js/select2.full.min.js", CONF_VIEW_ADMIN); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= theme("dist/js/adminlte.js", CONF_VIEW_ADMIN); ?>"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?= theme("dist/js/pages/dashboard.js", CONF_VIEW_ADMIN); ?>"></script>
    <script src="<?= theme("assets/js/scripts.js", CONF_VIEW_ADMIN); ?>"></script>
    </body>
</html>