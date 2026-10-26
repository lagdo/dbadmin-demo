<?php $this->extends('tpl::layout') ?>

<?php
use Lagdo\DbAdmin\App\DbAuditPackage;

use function Jaxon\attr;

$jaxon = Jaxon\jaxon();
?>

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
<script type='text/javascript'>
  <?= $readyScript ?>;
</script>
<?php $this->endblock() ?>

<?php $this->block('pageContent') ?>
        <div style="padding-right: 1rem; padding-left: 1rem;">
          <?php echo $jaxon->package(DbAuditPackage::class)->layout() ?>
        </div>
<?php $this->endblock() ?>
