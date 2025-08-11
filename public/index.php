<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Jaxon DbAdmin Demo</title>
        <link href="sb-admin/dist/css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <style>
            .row {
                margin-bottom: 10px;
            }
        </style>
<?php
require __DIR__ . '/../jaxon.php';

use Lagdo\DbAdmin\Ajax\App\Sidebar;
use Lagdo\DbAdmin\Ajax\App\Wrapper;

use function Jaxon\attr;
use function Jaxon\cl;
use function Jaxon\rq;

$jaxon = Jaxon\jaxon();
$package = $jaxon->package(Lagdo\DbAdmin\Package::class);
echo $jaxon->getCss(), "\n";
?>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Jaxon DbAdmin Demo</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        </nav>

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion" id="sidenavAccordion">
                    <div class="sb-sidenav-menu" style="padding: 10px 0 0 10px;">
                        <div class="nav" <?php echo attr()->bind(rq(Sidebar::class)) ?>>
                            <?php echo cl(Sidebar::class)->html() ?>
                        </div>
                    </div>
                </nav>
            </div>

            <div id="layoutSidenav_content">
                <main id="jaxon-dbadmin">
                    <div class="container-fluid px-4" <?php echo attr()->bind(rq(Wrapper::class)) ?> style="padding-top: 10px;">
                        <?php echo cl(Wrapper::class)->html() ?>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="sb-admin/dist/js/scripts.js"></script>
<?php
echo $jaxon->getJs(), "\n", $jaxon->getScript(), "\n";
?>
</html>
