<?php

require __DIR__ . '/vendor/autoload.php';

$app = new \Shortener\Commands\ClearExpiredLinks();
$app->run();