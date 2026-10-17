<?php

require_once dirname(__DIR__) . '/app/boot.php';

use Lagdo\DbAdmin\Support\Facade\Export;

$filename = $_GET['file'] ?? null;
if ($filename === null) {
    send_error('No file to export.');
    return;
}

$options = Export::options($filename);
$chunks = $options !== null ? Export::export($options) : null;
if ($chunks === null) {
    send_error("Unable to export file $filename.");
    return;
}

header("Content-Type: {$options->contentType}; charset=utf-8");
header("Content-Disposition: {$options->contentDisposition}; filename=\"{$options->filename}\"");
header('Cache-Control: no-cache');
header('X-Accel-Buffering: no');

foreach ($chunks as $chunk) {
    echo $chunk;
    flush();
}
