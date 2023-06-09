<?php

namespace Shortener\Models;

class TelegramConnection
{
    public string $token;
    public string $chatID;

    public function __construct(string $token, string $chatID)
    {
        $this->token = $token;
        $this->chatID = $chatID;
    }
}