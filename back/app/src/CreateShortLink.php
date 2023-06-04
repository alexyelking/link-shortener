<?php

namespace Shortener;

use mysqli;
use PhpAmqpLib\Channel\AMQPChannel;
use Redis;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class CreateShortLink
{
    private mysqli $db;
    private Redis $redis;
    private AMQPChannel $channel;

    public function __construct(mysqli $db, Redis $redis, AMQPChannel $channel)
    {
        $this->db = $db;
        $this->redis = $redis;
        $this->channel = $channel;
    }

    public function handle()
    {
        $ip = $_SERVER['SERVER_ADDR'];
        $limit = 10;
        if (!empty($_POST['source'])) {
            if ((int)$this->redis->get($ip) < $limit) {
                $source = $_POST['source'];

                $short = $this->getShort();

                $sql = "INSERT INTO links (source, short) VALUES (?, ?)";
                $statement = $this->db->prepare($sql);
                $statement->bind_param("ss", $source, $short);
                $statement->execute();

                $this->redis->incr($ip);
                $this->redis->expire($ip, 60);

                $link = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $short;


                $msg = new AMQPMessage('There was a reduction of some link.' . "%0A" . 'Source link: ' . urlencode($source) . "%0A" . 'Short link: ' . $link);
                $this->channel->basic_publish($msg, '', 'cat-queue');


                header('Content-Type: application/json; charset=utf-8');
                echo json_encode([
                    "message" => "Create successful",
                    "data" => [
                        "short" => $short,
                        "link" => $link
                    ]
                ]);
            } else {
                http_response_code(429);
                echo "Too many requests";
            }

        } else {
            http_response_code(422);
            echo "Source link is required";
        }
    }

    public function getShort(): string
    {
        $uniqValue = uniqid();
        $uniqString = "";

        $timeValue = time();

        $supplementString = "";

        for ($i = 0; $i < 4; $i++) {
            $uniqString .= $uniqValue[rand(0, 12)];
            $supplementValue = $timeValue % (rand(1, 10));
            $supplementString .= $supplementValue;
        }
        $uniqString .= $supplementString;
        return $uniqString;
    }
}