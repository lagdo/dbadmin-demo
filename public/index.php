<?php

use Lagdo\Facades\Logger;

require dirname(__DIR__) . '/config/jaxon.php';

// Show the index page.
Logger::debug('Render template', ['page' => page()]);
echo jaxon()->view()->render('tpl::' . page());
