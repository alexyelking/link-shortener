<?php

namespace Shortener\Configs;

interface IDatabaseConfig
{
    public function getHost();

    public function getUsername();

    public function getPassword();

    public function getName();
}