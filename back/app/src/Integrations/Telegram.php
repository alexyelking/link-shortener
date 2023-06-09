<?php

namespace Shortener\Integrations;

use Shortener\Configs\Config;
use Shortener\Configs\TelegramConfig;

class Telegram
{
    private string $host = 'https://api.telegram.org';
    private string $token;
    private string $chatID;

    public function __construct()
    {
        $config = new Config();
        $connection = $config->load(new TelegramConfig());
        $this->token = $connection->token;
        $this->chatID = $connection->chatID;
    }

    public function send(string $message): void
    {
        if ($curl = curl_init()) {
            $url = $this->host . '/bot' . $this->token . '/sendMessage?chat_id=' . $this->chatID . '&text=' . $message;
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_exec($curl);
            curl_close($curl);
        }
    }
}