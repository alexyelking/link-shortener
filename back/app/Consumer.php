<?php

require __DIR__ . '/vendor/autoload.php';

$app = new \Shortener\TGConsumer();
$app->run();