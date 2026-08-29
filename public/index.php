<?php

require_once dirname(__DIR__) . '/app/boot.php';

// Show the index page.
echo jaxon()->template()->render('tpl::' . page());
