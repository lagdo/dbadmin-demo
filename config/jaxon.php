<?php

use Jaxon\App\Dialog\AlertInterface;
use Lagdo\DbAdmin\Ajax\Exception\AppException;
use Lagdo\DbAdmin\Ajax\Exception\ValidationException;

function page(): string
{
    return ($_GET['page'] ?? '') === 'audit' ? 'dbaudit' : 'dbadmin';
}

require dirname(__DIR__, 2) . '/vendor/autoload.php';

/** @var AlertInterface */
$dialog = jaxon()->getResponse()->dialog;
$warningHandler = fn(Exception $e) => $dialog->title('Warning')->warning($e->getMessage());
$errorHandler = fn(Exception $e) => $dialog->title('Error')->error($e->getMessage());

jaxon()->callback()->error($warningHandler, AppException::class);
jaxon()->callback()->error($errorHandler, ValidationException::class);
jaxon()->callback()->error($errorHandler);

$appDir = dirname(__DIR__);
$page = page();

jaxon()->app()->setup(__DIR__ . "/$page.php");
