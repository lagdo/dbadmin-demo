<?php

use Lagdo\Facades\ContainerWrapper;
use Psr\Container\ContainerInterface;

require(__DIR__ . '/../vendor/autoload.php');

$sCacheDirKey = 'jaxon_annotations_cache_dir';
jaxon()->di()->val($sCacheDirKey, '/var/cache/jaxon');
jaxon()->app()->setup(__DIR__ . '/config.php');

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
