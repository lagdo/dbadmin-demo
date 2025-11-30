<?php

require dirname(__DIR__) . '/config/jaxon.php';

// Set the content type
header('Content-Type: text/plain');

$package = jaxon()->package(Lagdo\DbAdmin\DbAdminPackage::class);
$reader = $package->getOption('export.reader');
if (!is_callable($reader)) {
    echo "No export reader set.";
    exit;
}

echo $reader($_GET['file'] ?? '');
