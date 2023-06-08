<?php

namespace Shortener\Configs;

interface IRedisConfig
{
    public function getHost();

    public function getPort();

    public function getLimitCount();

    public function getLimitTime();
}