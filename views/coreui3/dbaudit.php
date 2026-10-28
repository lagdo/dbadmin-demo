<?php $this->extends('tpl::layout') ?>

<?php $this->block('htmlHeader') ?>
<?= jaxon_css() ?>
<?php $this->endblock() ?>

<?php $this->block('htmlFooter') ?>
<?= jaxon_js() ?>

<?= jaxon_script() ?>

<script type='text/javascript'>
  <?= jaxon_ready() ?>
</script>
<?php $this->endblock() ?>

<?php $this->block('pageContent') ?>
        <div class="container-fluid px-3">
          <?= ui_builder()->layout() ?>
        </div>
<?php $this->endblock() ?>
