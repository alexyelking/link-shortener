<?php

namespace Shortener;

require __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Consumer
{
    public function handle(AMQPMessage $msg){
        $tg = new TelegramNotification();
        $tg->send($msg->getBody());
        echo $msg->getBody();
        echo "\n";
    }
}

$consumer = new Consumer();
$callback = function ($msg) use ($consumer) {
    $consumer->handle($msg);
};

$connection = new AMQPStreamConnection('rabbit', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('cat-queue', false, true, false, false);
$channel->basic_consume('cat-queue', '', false, true, false, false, $callback);

while ($channel->is_open()) {
    $channel->wait();
}