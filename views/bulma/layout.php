<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Jaxon DbAdmin</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <link rel="stylesheet" href="/bulma/badge.min.css">
    <link rel="stylesheet" href="/bulma/checkbox.min.css">
    <link rel="stylesheet" href="/bulma/radio.min.css">
    <link rel="stylesheet" href="/bulma/switch.min.css">
    <link rel="stylesheet" href="/bulma/styles.css">
    <style>
      html {
        font-size: 14px;
      }
      header.modal-card-head, section.modal-card-body, footer.modal-card-foot {
        padding: 1rem;
      }
      @media screen and (min-width: 769px) {
        #bulma-modal-container .modal-card, #bulma-modal-container .modal-content {
          width: 800px;
        }
      }
    </style>

    <?= $this->htmlHeader ?>
  </head>

  <body>
    <div style="padding-top: 5px;">
      <div id="app">
        <?= $this->pageContent ?>
      </div>
    </div>

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.min.js"></script>

    <?= $this->htmlFooter ?>

    <script src="/bulma/scripts.js"></script>
  </body>
</html>
