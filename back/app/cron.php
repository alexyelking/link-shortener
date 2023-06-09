<?php

require __DIR__ . '/vendor/autoload.php';

$_ENV['DB_HOST']='db';
$_ENV['DB_USERNAME']='root';
$_ENV['DB_PASSWORD']='root';
$_ENV['DB_NAME']='shortener_db';

$app = new \Shortener\Commands\ClearExpiredLinks();
$app->run();