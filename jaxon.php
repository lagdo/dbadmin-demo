<?php

use Jaxon\App\Dialog\AlertInterface;
use Lagdo\DbAdmin\Ajax\AppException;
use Lagdo\Facades\ContainerWrapper;
use Psr\Container\ContainerInterface;

require(__DIR__ . '/../vendor/autoload.php');

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

jaxon()->di()->val('jaxon_annotations_cache_dir', '/var/cache/jaxon');
jaxon()->app()->setup(__DIR__ . '/dbadmin.php');
