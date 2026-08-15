<?php

require_once dirname(__DIR__) . '/app/boot.php';

use Lagdo\DbAdmin\Support\Facade\FileSystem;

// Set the content type
header('Content-Type: text/plain');

$fs = FileSystem::instance();
echo !$fs ? "No export reader set." : $fs->read($_GET['file'] ?? '');
