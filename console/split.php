#!/usr/local/bin/php
<?php

use Lagdo\DbAdmin\Support\Service\Query\QuerySplitter;

require dirname(__DIR__) . '/app/boot.php';

$splitter = jaxon()->di()->g(QuerySplitter::class);
(new Lagdo\DbAdmin\Demo\SplitterCommand($splitter))->run();
