<?php

namespace Shortener\Configs;

class Config
{
    public function load(ILoadConfig $loadConfig)
    {
        return $loadConfig->loadConfig();
    }
}