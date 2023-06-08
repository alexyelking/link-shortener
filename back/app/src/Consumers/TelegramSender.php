<?php

namespace Shortener\Consumers;

use PhpAmqpLib\Message\AMQPMessage;
use Shortener\Integrations\Telegram;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class TelegramSender
{
    private string $host;
    private int $port;
    private string $user;
    private string $password;

    public function __construct()
    {
        $this->host = $_ENV['AMQP_HOST'];
        $this->port = $_ENV['AMQP_PORT'];
        $this->user = $_ENV['AMQP_USER'];
        $this->password = $_ENV['AMQP_PASSWORD'];
    }

    public function run(): void
    {
        $consumer = new TelegramSender();
        $callback = function ($msg) use ($consumer) {
            $consumer->sendMessage($msg);
        };

        $connection = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->password);
        $channel = $connection->channel();

        $channel->queue_declare('cat-queue', false, true, false, false);
        $channel->basic_consume('cat-queue', '', false, true, false, false, $callback);

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