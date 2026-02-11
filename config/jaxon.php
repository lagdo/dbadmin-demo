<?php

use Lagdo\DbAdmin\Ajax\Exception\AppException;
use Lagdo\DbAdmin\Ajax\Exception\ValidationException;
use Lagdo\Facades\ContainerWrapper;
use Psr\Log\LoggerInterface;

function page(): string
{
    return ($_GET['page'] ?? '') === 'audit' ? 'dbaudit' : 'dbadmin';
}

require dirname(__DIR__, 2) . '/vendor/autoload.php';

$appDir = dirname(__DIR__);
$page = page();

$dotenv = Dotenv\Dotenv::createUnsafeImmutable($appDir);
$dotenv->load();

$dialog = jaxon()->getResponse()->dialog();
$warningHandler = fn(Exception $e) => $dialog->title('Warning')->warning($e->getMessage());
$errorHandler = fn(Exception $e) => $dialog->title('Error')->error($e->getMessage());

jaxon()->callback()->error($warningHandler, AppException::class);
jaxon()->callback()->error($errorHandler, ValidationException::class);
jaxon()->callback()->error($errorHandler);

ContainerWrapper::registerLocalServices([
    'filename' => "$appDir/logs/$page",
]);
jaxon()->di()->setLogger(ContainerWrapper::getContainer()->get(LoggerInterface::class));

jaxon()->app()->setup(__DIR__ . "/$page.php");
