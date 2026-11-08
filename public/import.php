<?php

require_once dirname(__DIR__) . '/app/boot.php';

use Lagdo\DbAdmin\Support\Facade\Import;

$filename = $_GET['file'] ?? null;
if ($filename === null) {
    send_error('No file to import.');
    return;
}

$options = Import::options($filename);
$imports = Import::import($options);
if ($imports === null) {
    send_error("Unable to import file $filename.");
    return;
}

header('Content-Type: ' . $options->contentType());
header('Content-Disposition: ' . $options->contentDisposition());
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('X-Accel-Buffering: no');

foreach ($imports as $import) {
    echo $import;
    if (ob_get_level() > 0) {
        ob_flush();
    }
    flush();
}
