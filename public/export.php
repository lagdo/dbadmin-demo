<?php

require_once dirname(__DIR__) . '/app/boot.php';

use Lagdo\DbAdmin\Support\Facade\FileSystem;

// Set the content type
header('Content-Type: text/plain');

echo FileSystem::instance()?->read($_GET['file'] ?? '') ?? 'No export reader set.';
