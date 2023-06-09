<?php

namespace Shortener\Configs;

use Shortener\Models\TelegramConnection;

class TelegramConfig implements ILoadConfig
{
    public string $token;
    public string $chatID;

    public function __construct()
    {
        $this->token = $_ENV['TG_TOKEN'];
        $this->chatID = $_ENV['TG_CHAT_ID'];
    }

    public function loadConfig()
    {
        return new TelegramConnection($this->token, $this->chatID);
    }
}