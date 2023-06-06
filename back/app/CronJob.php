<?php

require __DIR__ . '/vendor/autoload.php';

$app = new \Shortener\Commands\CronJobCommand();
$app->run();