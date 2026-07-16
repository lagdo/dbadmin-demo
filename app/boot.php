<?php

require_once __DIR__ . '/lib.php';
require dirname(__DIR__, 2) . '/vendor/autoload.php';

use Lagdo\DbAdmin\App\Ajax\Exception\AppException;
use Lagdo\DbAdmin\App\Ajax\Exception\ValidationException;
use Lagdo\Facades\ContainerWrapper;
use Lagdo\Facades\Logger;

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(base_dir());
$dotenv->load();

$dialog = jaxon()->getResponse()->dialog();
$warningHandler = fn(Exception $e) =>
    $dialog->title('Warning')->warning($e->getMessage());
$errorHandler = fn(Exception $e) =>
    $dialog->title('Error')->error($e->getMessage());
jaxon()->callback()
    ->error($warningHandler, AppException::class)
    ->error($errorHandler, ValidationException::class)
    ->error($errorHandler);

ContainerWrapper::registerLocalServices([
    'filename' => base_dir() . '/logs/' . page(),
]);
jaxon()->di()->setLogger(Logger::instance());

jaxon()->app()->setup(__DIR__ . '/config/' . page() . '.php');
