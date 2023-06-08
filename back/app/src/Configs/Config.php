<?php

namespace Shortener\Configs;

class Config implements IDatabaseConfig
{
    private $host;
    private $username;
    private $password;
    private $name;

    public function load()
    {
        //TODO
    }

    public function getHost()
    {
        $this->host = $_ENV['DB_HOST'];
    }

    public function getUsername()
    {
        $this->username = $_ENV['DB_USERNAME'];
    }

    public function getPassword()
    {
        $this->password = $_ENV['DB_PASSWORD'];
    }

    public function getName()
    {
        $this->name = $_ENV['DB_NAME'];
    }
}