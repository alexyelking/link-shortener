<?php

namespace Shortener\Configs;

interface IAMQPConfig
{
    public function getHost();

    public function getPort();

    public function getUser();

    public function getPassword();
}