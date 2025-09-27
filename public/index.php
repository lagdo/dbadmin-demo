<?php

require dirname(__DIR__) . '/config/jaxon.php';

// Show the index page.
echo jaxon()->view()->render('tpl::' . page());
