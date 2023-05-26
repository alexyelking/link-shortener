<?php
require __DIR__ . '/vendor/autoload.php';

$redis = new Redis();
$redis->connect('redis', 6379);
$redis->select(1);

$key = 'abc';
$redis->incr($key);
$redis->expire($key, 60);
