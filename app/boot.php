<?php

require_once __DIR__ . '/lib.php';
require dirname(__DIR__, 2) . '/vendor/autoload.php';

use Lagdo\DbAdmin\App\Ajax\Exception\AppException;
use Lagdo\DbAdmin\App\Ajax\Exception\ValidationException;
use Lagdo\DbAdmin\Driver\Exception\DriverException;
use Lagdo\Facades\ContainerWrapper;
use Lagdo\Facades\Logger;

$baseDir = base_dir();
Dotenv\Dotenv::createImmutable($baseDir)->safeLoad();
Dotenv\Dotenv::createImmutable($baseDir, '.env.dbadmin')->safeLoad();

$jaxon = jaxon();

$dialog = $jaxon->getResponse()->dialog();
$warningHandler = fn(Exception $e) =>
    $dialog->title('Warning')->warning($e->getMessage());
$errorHandler = fn(Exception $e) =>
    $dialog->title('Error')->error($e->getMessage());
$jaxon->callback()
    ->error($warningHandler, AppException::class)
    ->error($errorHandler, DriverException::class)
    ->error($errorHandler, ValidationException::class)
    ->error($errorHandler);

ContainerWrapper::registerLocalServices([
    'filename' => log_file(),
]);
$jaxon->di()->setLogger(Logger::instance());

setup_app();
// Register the view templates.
$template = $jaxon->getAppOption('template', '');
$jaxon->template()->addNamespace('tpl', "$baseDir/views/$template", '.php');

$jaxon->app()->setup(setup_file());
