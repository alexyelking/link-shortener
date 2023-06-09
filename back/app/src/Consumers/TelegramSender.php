<?php

namespace Shortener\Consumers;

use PhpAmqpLib\Message\AMQPMessage;
use Shortener\Integrations\Telegram;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class TelegramSender
{
    public function run(): void
    {
        $callback = function (AMQPMessage $msg) {
            $this->sendMessage($msg);
        };

        $connection = new AMQPStreamConnection($_ENV['AMQP_HOST'], $_ENV['AMQP_PORT'], $_ENV['AMQP_USER'], $_ENV['AMQP_PASSWORD']);
        $channel = $connection->channel();

        $channel->queue_declare('short-notification-queue', false, true, false, false);
        $channel->basic_consume('short-notification-queue', '', false, true, false, false, $callback);

        while ($channel->is_open()) {
            $channel->wait();
        }
    }

    public function sendMessage(AMQPMessage $message): void
    {
        $telegram = new Telegram();
        $telegram->send($message->getBody());
    }
}