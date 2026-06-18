#!/usr/local/bin/php
<?php

require dirname(__DIR__) . '/app/boot.php';

Lagdo\UiBuilder\Jaxon\registerUiBuilder();

$bootCallbacks = jaxon()->callback()->popBootCallbacks();
foreach ($bootCallbacks as $callback) {
    $callback();
}

$command = new Lagdo\DbAdmin\Demo\SplitterCommand();
$command->run();
