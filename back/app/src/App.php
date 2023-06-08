<?php

namespace Shortener;

use Redis;
use Shortener\Controllers\GetLinks;
use Shortener\Controllers\NotFound;
use Shortener\Controllers\Redirect;
use Shortener\Controllers\CreateLink;
use Shortener\Infrastructure\Database;
use Shortener\Repositories\LinkRepository;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class App
{
    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Request-Method: POST");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin");
        header('Content-Type: application/json; charset=utf-8');
    }

    public function run(): void
    {
        $database = new Database();
        $mysql = $database->connect();

        $linksRepository = new LinkRepository($mysql);

        $redis = new Redis();
        $redis->connect($_ENV['REDIS_HOST'], $_ENV['REDIS_PORT']);
        $redis->select($_ENV['REDIS_DATABASE']);

        $AMQPConnection = new AMQPStreamConnection($_ENV['AMQP_HOST'], $_ENV['AMQP_PORT'], $_ENV['AMQP_USER'], $_ENV['AMQP_PASSWORD']);
        $AMQPChannel = $AMQPConnection->channel();
        $AMQPChannel->queue_declare('cat-queue', false, true, false, false);

        switch (true) {
            case $_SERVER['REDIRECT_URL'] == '/links' && $_SERVER['REQUEST_METHOD'] == 'GET':
                $getLinks = new GetLinks($linksRepository);
                $getLinks->getLinks();
                break;
            case $_SERVER['REDIRECT_URL'] == '/link/create' && $_SERVER['REQUEST_METHOD'] == 'POST':
                $link = new CreateLink($linksRepository, $redis, $AMQPChannel);
                $link->getShort();
                break;
            case strlen($_SERVER['REDIRECT_URL']) == 9 && $_SERVER['REQUEST_METHOD'] == 'GET':
                $redirect = new Redirect($linksRepository);
                $redirect->tryRedirect();
                break;
            default:
                $notFound = new NotFound();
                $notFound->throw();
                break;
        }

        $mysql->close();

        $redis->close();

        $AMQPChannel->close();
        $AMQPConnection->close();
    }
}