<?php $this->extends('tpl::layout') ?>

<?php
use Lagdo\DbAdmin\Ajax\App\Sidebar;
use Lagdo\DbAdmin\Ajax\App\Wrapper;
use Lagdo\DbAdmin\DbAdminPackage;

use function Jaxon\attr;
use function Jaxon\cl;
use function Jaxon\rq;

$jaxon = Jaxon\jaxon();
?>

<?php $this->block('navbar') ?>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
      <!-- Navbar Brand-->
      <a class="navbar-brand ps-3" href="index.html">Jaxon DbAdmin Demo</a>
      <!-- Sidebar Toggle-->
      <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    </nav>
<?php $this->endblock() ?>

<?php $this->block('header') ?>
<?php
echo $jaxon->getCss(), "\n";
?>
<?php $this->endblock() ?>

<?php $this->block('footer') ?>
<?php
echo $jaxon->getJs(), "\n", $jaxon->getScript(), "\n";
$readyScript = attr()->package(DbAdminPackage::class, 'ready');
?>
<?php if($readyScript !== ''): ?>
<script type='text/javascript'>
  <?= $readyScript ?>;
</script>
<?php endif ?>
<?php $this->endblock() ?>

<?php $this->block('content') ?>
    <div id="layoutSidenav">
      <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion" id="sidenavAccordion">
          <div class="sb-sidenav-menu" <?php echo attr()->bind(rq(Sidebar::class)) ?>>
            <?php echo cl(Sidebar::class)->html() ?>
          </div>
        </nav>
      </div>

      <div id="layoutSidenav_content">
        <main id="jaxon-dbadmin">
          <div class="container-fluid" <?php echo attr()->bind(rq(Wrapper::class)) ?>>
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
<?php $this->endblock() ?>
