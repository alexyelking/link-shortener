<?php

namespace Shortener;

require __DIR__ . '/vendor/autoload.php';

class Consumer
{
    public function handle(){
        echo "hello world\n";
    }
}

$consumer = new Consumer();
$consumer->handle();