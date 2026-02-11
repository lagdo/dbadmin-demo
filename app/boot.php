<?php

use Lagdo\DbAdmin\Ajax\Exception\AppException;
use Lagdo\DbAdmin\Ajax\Exception\ValidationException;
use Lagdo\Facades\ContainerWrapper;
use Lagdo\Facades\Logger;

function page(): string
{
    return ($_GET['page'] ?? '') === 'audit' ? 'dbaudit' : 'dbadmin';
}

function base_dir(): string
{
    return dirname(__DIR__);
}

require dirname(__DIR__, 2) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(base_dir());
$dotenv->load();

$dialog = jaxon()->getResponse()->dialog();
$warningHandler = fn(Exception $e) => $dialog->title('Warning')->warning($e->getMessage());
$errorHandler = fn(Exception $e) => $dialog->title('Error')->error($e->getMessage());

jaxon()->callback()->error($warningHandler, AppException::class);
jaxon()->callback()->error($errorHandler, ValidationException::class);
jaxon()->callback()->error($errorHandler);

ContainerWrapper::registerLocalServices([
    'filename' => base_dir() . '/logs/' . page(),
]);
jaxon()->di()->setLogger(Logger::instance());

jaxon()->app()->setup(__DIR__ . '/config/' . page() . '.php');
