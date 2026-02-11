<?php

require dirname(__DIR__) . '/app/boot.php';

// Show the index page.
echo jaxon()->view()->render('tpl::' . page());
