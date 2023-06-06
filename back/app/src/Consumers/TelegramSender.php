<?php

namespace Shortener\Consumers;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Shortener\Integrations\Telegram;

class TelegramSender
{
    private $host;
    private $port;
    private $user;
    private $password;

    public function __construct()
    {
        $this->host = $_ENV['RABBIT_HOST'];
        $this->port = $_ENV['RABBIT_PORT'];
        $this->user = $_ENV['RABBIT_USER'];
        $this->password = $_ENV['RABBIT_USER_PASSWORD'];
    }

    public function run()
    {
        $consumer = new TelegramSender();
        $callback = function ($msg) use ($consumer) {
            $consumer->handle($msg);
        };

        $connection = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->password);
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