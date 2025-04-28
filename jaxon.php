<?php

require(__DIR__ . '/../vendor/autoload.php');

$sCacheDirKey = 'jaxon_annotations_cache_dir';
Jaxon\jaxon()->di()->val($sCacheDirKey, '/var/cache/jaxon');

Jaxon\jaxon()->app()->setup(__DIR__ . '/config.php');
