<?php

require dirname(__DIR__) . '/app/boot.php';

// Set the content type
header('Content-Type: text/plain');

$package = jaxon()->package(Lagdo\DbAdmin\Db\DbAdminPackage::class);
$reader = $package->getOption('export.reader');

echo !is_callable($reader) ? "No export reader set." : $reader($_GET['file'] ?? '');
