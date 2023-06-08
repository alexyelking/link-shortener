<?php

namespace Shortener\Controllers;

use Redis;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;
use Shortener\Repositories\LinkRepository;

class CreateLink
{
    private LinkRepository $links;
    private Redis $redis;
    private AMQPChannel $channel;
    private int $limitCount;
    private int $limitTime;

    public function __construct(LinkRepository $links, Redis $redis, AMQPChannel $channel)
    {
        $this->links = $links;
        $this->redis = $redis;
        $this->channel = $channel;
        $this->limitCount = $_ENV['REDIS_LIMIT_COUNT'];
        $this->limitTime = $_ENV['REDIS_LIMIT_TIME'];
    }

    public function getShort(): void
    {
        if (empty($_POST['source'])) {
            http_response_code(422);
            echo "Source link is required";
            return;
        }

        $ip = $_SERVER['SERVER_ADDR'];

        if ((int)$this->redis->get($ip) >= $this->limitCount) {
            http_response_code(429);
            echo "Too many requests";
            return;
        } else {
            $this->redis->incr($ip);
            $this->redis->expire($ip, $this->limitTime);
        }

        $source = $_POST['source'];

        $link = $this->links->create($source);

        $shortUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $link->short;

        $msg = new AMQPMessage('There was a reduction of some link.' . "%0A" . 'Source link: ' . urlencode($source) . "%0A" . 'Short link: ' . $shortUrl);
        $this->channel->basic_publish($msg, '', 'cat-queue');

        echo json_encode([
            "message" => "Create successful",
            "data" => [
                "id" => $link->id,
                "source" => $link->source,
                "short" => $shortUrl,
                "created_at" => $link->created_at
            ]
        ]);
    }
}