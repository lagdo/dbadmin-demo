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
      html {
        font-size: 14px;
      }
      .row {
        margin-bottom: 10px;
      }
      .sb-sidenav-menu {
        padding-top: 20px;
        padding-left: 7px;
      }
      .sb-sidenav-menu > .row {
        margin-right: 0px;
      }
    </style>
    <?= $this->header ?>
  </head>
  <body class="sb-nav-fixed">
    <?= $this->navbar ?>

    <?= $this->content ?>
  </body>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="sb-admin/dist/js/scripts.js"></script>
  <?= $this->footer ?>
</html>
