<?php

namespace Shortener\Consumers;

use PhpAmqpLib\Message\AMQPMessage;
use Shortener\Integrations\Telegram;
use Shortener\Infrastructure\AMQPConnectionReturner;

class TelegramSender
{
    public function run(): void
    {
        $callback = function (AMQPMessage $msg) {
            $this->sendMessage($msg);
        };

        $AMQPConnection = new AMQPConnectionReturner();
        $AMQPChannel = $AMQPConnection->connect();
        $AMQPChannel->basic_consume('short-notification-queue', '', false, true, false, false, $callback);

        while ($AMQPChannel->is_open()) {
            $AMQPChannel->wait();
        }
    }

    public function sendMessage(AMQPMessage $message): void
    {
        $telegram = new Telegram();
        $telegram->send($message->getBody());
    }
}