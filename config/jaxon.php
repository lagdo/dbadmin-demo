<?php

use Jaxon\App\Dialog\AlertInterface;
use Lagdo\DbAdmin\Ajax\AppException;
use Lagdo\Facades\ContainerWrapper;
use Psr\Container\ContainerInterface;

function page(): string
{
    return ($_GET['page'] ?? '') === 'log' ? 'logging' : 'dbadmin';
}

require dirname(__DIR__, 2) . '/vendor/autoload.php';

ContainerWrapper::setContainer(new class implements ContainerInterface
    {
        public function get($id)
        {
            return jaxon()->di()->g($id);
        }

        public function has($id): bool
        {
            return jaxon()->di()->h($id);
        }
    }
);

/** @var AlertInterface */
$alert = jaxon()->getResponse()->dialog;
$callback = fn(AppException $e) => $alert->title('Warning')->warning($e->getMessage());
jaxon()->callback()->error($callback, AppException::class);

$appDir = dirname(__DIR__);
$page = page();

jaxon()->di()->val('jaxon_annotations_cache_dir', "$appDir/cache/$page");
jaxon()->app()->setup(__DIR__ . "/$page.php");
