<?php require(__DIR__ . '/../jaxon.php') ?>
<?php require(__DIR__ . '/../views/header.php') ?>

        <div id="layoutSidenav">
<?php require(__DIR__ . '/../views/sidebar.php') ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4" <?php echo Jaxon\attr()->bind(Jaxon\rq(Lagdo\DbAdmin\Ajax\App\Admin::class)) ?>>
<?php echo Jaxon\jaxon()->package(Lagdo\DbAdmin\Package::class)->getHtml() ?>
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

<?php require(__DIR__ . '/../views/footer.php') ?>
