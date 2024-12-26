<?php

require(__DIR__ . '/../vendor/autoload.php');

$sCacheDirKey = 'jaxon_annotations_cache_dir';
Jaxon\jaxon()->di()->val($sCacheDirKey, __DIR__ . '/cache/annotations');

Jaxon\jaxon()->app()->setup(__DIR__ . '/config.php');
