<?php

require __DIR__ . '/vendor/autoload.php';

$app = new \Shortener\Consumers\TelegramSender();
$app->run();