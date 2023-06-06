<?php

namespace Shortener;

use PhpAmqpLib\Channel\AMQPChannel;
use Redis;
use PhpAmqpLib\Message\AMQPMessage;
use Shortener\Repositories\LinkRepository;

class CreateShortLink
{
    private LinkRepository $links;
    private Redis $redis;
    private AMQPChannel $channel;

    public function __construct(LinkRepository $links, Redis $redis, AMQPChannel $channel)
    {
        $this->links = $links;
        $this->redis = $redis;
        $this->channel = $channel;
    }

    public function handle()
    {
        if (empty($_POST['source'])) {
            http_response_code(422);
            echo "Source link is required";
            return;
        }

        $ip = $_SERVER['SERVER_ADDR'];
        $limit = 10;

        if ((int)$this->redis->get($ip) >= $limit) {
            http_response_code(429);
            echo "Too many requests";
            return;
        } else {
            $this->redis->incr($ip);
            $this->redis->expire($ip, 60);
        }

        $source = $_POST['source'];

        $link = $this->links->create($source);

        $shortUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $link->short;

        $msg = new AMQPMessage('There was a reduction of some link.' . "%0A" . 'Source link: ' . urlencode($source) . "%0A" . 'Short link: ' . $shortUrl);
        $this->channel->basic_publish($msg, '', 'cat-queue');

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            "message" => "Create successful",
            "data" => [
                "short" => $link->short,
                "link" => $shortUrl
            ]
        ]);
    }
}