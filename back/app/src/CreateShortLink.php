<?php

namespace Shortener;

use mysqli;
use Redis;

class CreateShortLink
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    public function handle()
    {
        $ip = $_SERVER['SERVER_ADDR'];
        $limit = 10;
        if (!empty($_POST['source'])) {
            $redis = new Redis();
            $redis->connect('redis', 6379);
            $redis->select(1);
            if ((int)$redis->get($ip) < $limit) {
                $source = $_POST['source'];

                $short = $this->getShort();

                $sql = "INSERT INTO links (source, short) VALUES (?, ?)";
                $statement = $this->db->prepare($sql);
                $statement->bind_param("ss", $source, $short);
                $statement->execute();

                $redis->incr($ip);
                $redis->expire($ip, 60);

                $link = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $short;

                $tg = new TelegramNotification();
                $tg->send('There was a reduction of some link.' . "%0A" . 'Source link: ' . (string)$source . "%0A" . 'Short link: ' . $link);

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