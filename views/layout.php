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
      #layoutSidenav_content {
          padding-top: 10px;
      }
    </style>
    <?= $this->header ?>
  </head>
  <body>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
      <?= $this->navbar ?>
    </nav>

    <div id="layoutSidenav">
      <div id="layoutSidenav_content">
        <main>
          <?= $this->content ?>
        </main>
      </div>
    </div>

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
  </body>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="sb-admin/dist/js/scripts.js"></script>
  <?= $this->footer ?>
</html>
