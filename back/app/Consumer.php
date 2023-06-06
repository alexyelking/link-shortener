<?php

require __DIR__ . '/vendor/autoload.php';

$app = new \Shortener\Consumers\TGConsumer();
$app->run();