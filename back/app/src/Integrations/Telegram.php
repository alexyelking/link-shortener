<?php

namespace Shortener\Integrations;

class Telegram
{
    private string $host = 'https://api.telegram.org';

    public function send(string $message): void
    {
        if ($curl = curl_init()) {
            $url = $this->host . '/bot' . $_ENV['TG_TOKEN'] . '/sendMessage?chat_id=' . $_ENV['TG_CHAT_ID'] . '&text=' . $message;
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_exec($curl);
            curl_close($curl);
        }
    }
}