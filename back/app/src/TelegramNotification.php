<?php

namespace Shortener;

class TelegramNotification
{
    private $token;
    private $host = 'https://api.telegram.org';
    private $chat_id;

    public function __construct()
    {
        $this->token = $_ENV['TG_TOKEN'];
        $this->chat_id = $_ENV['TG_CHAT_ID'];
    }

    public function send(string $message)
    {
        if ($curl = curl_init()) {
            $url = $this->host . '/bot' . $this->token . '/sendMessage?chat_id=' . $this->chat_id . '&text=' . $message;
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_exec($curl);
            curl_close($curl);
        }
    }
}