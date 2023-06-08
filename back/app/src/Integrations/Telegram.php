<?php

namespace Shortener\Integrations;

class Telegram
{
    private string $token;
    private string $host = 'https://api.telegram.org';
    private string $chat_id;

    public function __construct()
    {
        $this->token = $_ENV['TG_TOKEN'];
        $this->chat_id = $_ENV['TG_CHAT_ID'];
    }

    public function send(string $message): void
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