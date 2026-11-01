<?php

require_once dirname(__DIR__) . '/app/boot.php';

use Lagdo\DbAdmin\Support\Facade\Export;

$filename = $_GET['file'] ?? null;
if ($filename === null) {
    send_error('No file to export.');
    return;
}

$options = Export::options($filename);
$exports = Export::export($options);
if ($exports === null) {
    send_error("Unable to export file $filename.");
    return;
}

header('Content-Type: ' . $options->contentType());
header('Content-Disposition: ' . $options->contentDisposition());
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('X-Accel-Buffering: no');

foreach ($exports as $export) {
    echo $export;
    if (ob_get_level() > 0) {
        ob_flush();
    }
    flush();
}
