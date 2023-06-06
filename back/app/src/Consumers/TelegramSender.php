<?php

namespace Shortener\Consumers;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Shortener\Integrations\Telegram;

class TelegramSender
{
    public function run()
    {
        $consumer = new TelegramSender();
        $callback = function ($msg) use ($consumer) {
            $consumer->handle($msg);
        };

        $connection = new AMQPStreamConnection($_ENV['RABBIT_HOST'], $_ENV['RABBIT_PORT'], $_ENV['RABBIT_USER'], $_ENV['RABBIT_USER_PASSWORD']);
        $channel = $connection->channel();

        $channel->queue_declare('cat-queue', false, true, false, false);
        $channel->basic_consume('cat-queue', '', false, true, false, false, $callback);

        while ($channel->is_open()) {
            $channel->wait();
        }
    }

    public function handle(AMQPMessage $msg)
    {
        $tg = new Telegram();
        $tg->send($msg->getBody());
        echo $msg->getBody();
        echo "\n";
    }
}