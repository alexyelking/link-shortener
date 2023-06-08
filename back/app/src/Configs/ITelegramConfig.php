<?php

namespace Shortener\Configs;

interface ITelegramConfig
{
    public function getToken();

    public function getChatID();
}