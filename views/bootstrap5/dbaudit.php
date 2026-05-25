<?php $this->extends('tpl::layout') ?>

<?php
use Lagdo\DbAdmin\App\DbAuditPackage;

use function Jaxon\attr;

$jaxon = Jaxon\jaxon();
?>

<?php $this->block('pageHeader') ?>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
      <!-- Navbar Brand-->
      <a class="navbar-brand ps-3" href="/">Jaxon DbAdmin Demo Logs</a>
      <!-- Sidebar Toggle-->
      <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
        <i class="fas fa-bars"></i>
      </button>
    </nav>
<?php $this->endblock() ?>

<?php $this->block('htmlHeader') ?>
<?php
echo $jaxon->getCss(), "\n";
?>
<?php $this->endblock() ?>

<?php $this->block('htmlFooter') ?>
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

<?php $this->block('pageContent') ?>
        <div class="container-fluid px-3">
          <?php echo $jaxon->package(DbAuditPackage::class)->layout() ?>
        </div>
<?php $this->endblock() ?>
