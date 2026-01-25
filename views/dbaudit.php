<?php $this->extends('tpl::layout') ?>

<?php
use Lagdo\DbAdmin\Ajax\Audit\Sidebar;
use Lagdo\DbAdmin\Ajax\Audit\Wrapper;
use Lagdo\DbAdmin\Db\DbAuditPackage;

use function Jaxon\attr;
use function Jaxon\cl;
use function Jaxon\rq;

$jaxon = Jaxon\jaxon();
?>

<?php $this->block('navbar') ?>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
      <!-- Navbar Brand-->
      <a class="navbar-brand ps-3" href="index.html">Jaxon DbAdmin Demo Logs</a>
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
$readyScript = attr()->package(DbAuditPackage::class, 'ready');
?>
<?php if($readyScript !== ''): ?>
<script type='text/javascript'>
  <?= $readyScript ?>;
</script>
<?php endif ?>
<?php $this->endblock() ?>

<?php $this->block('content') ?>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-3">
          <?php echo $jaxon->package(DbAuditPackage::class)->layout() ?>
        </div>
      </main>
    </div>
<?php $this->endblock() ?>
