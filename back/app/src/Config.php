<?php

namespace Shortener;

class Config
{
    public function loadTelegramConfig()
    {
        $_ENV['TG_TOKEN'] = '6196289361:AAGxqexf6_Anpn8FtdkqaoyBwM-db1YXM1Q';
        $_ENV['TG_CHAT_ID'] = '1087256094';
    }

    public function loadRedisConfig()
    {
        $_ENV['REDIS_LIMIT_COUNT'] = 10;
        $_ENV['REDIS_LIMIT_TIME'] = 60;
    }

    public function loadDatabaseConfig()
    {
        $_ENV['DB_HOST'] = 'db';
        $_ENV['DB_USER_NAME'] = 'root';
        $_ENV['DB_USER_PASSWORD'] = 'root';
        $_ENV['DB_NAME'] = 'shortener_db';
    }

    public function loadAMQPConfig()
    {
        $_ENV['AMQP_HOST'] = 'rabbit';
        $_ENV['AMQP_PORT'] = '5672';
        $_ENV['AMQP_USER'] = 'guest';
        $_ENV['AMQP_PASSWORD'] = 'guest';
    }

    public function loadAllConfig()
    {
        $this->loadTelegramConfig();
        $this->loadRedisConfig();
        $this->loadDatabaseConfig();
        $this->loadAMQPConfig();
    }
}