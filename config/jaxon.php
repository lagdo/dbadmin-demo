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
$alert = jaxon()->getResponse()->dialog;
jaxon()->callback()->error(fn(AppException $e) => $alert->title('Warning')
    ->warning($e->getMessage()), AppException::class);
jaxon()->callback()->error(fn(ValidationException $e) => $alert->title('Error')
    ->error($e->getMessage()), ValidationException::class);

$appDir = dirname(__DIR__);
$page = page();

jaxon()->app()->setup(__DIR__ . "/$page.php");
