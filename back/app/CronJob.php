<?php

require __DIR__ . '/vendor/autoload.php';

$app = new \Shortener\CronJobCommand();
$app->run();