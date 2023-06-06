<?php

namespace Shortener;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Redis;
use Shortener\Controllers\CreateLink;
use Shortener\Controllers\GetLinks;
use Shortener\Controllers\NotFound;
use Shortener\Controllers\Redirect;
use Shortener\Infrastructure\Database;
use Shortener\Repositories\LinkRepository;

class App
{
    public function run()
    {
        $database = new Database();
        $mysql = $database->connect();

        $linksRepository = new LinkRepository($mysql);

        $redis = new Redis();
        $redis->connect('redis', 6379);
        $redis->select(1);

        $AMQPConnection = new AMQPStreamConnection('rabbit', 5672, 'guest', 'guest');
        $AMQPChannel = $AMQPConnection->channel();
        $AMQPChannel->queue_declare('cat-queue', false, true, false, false);

        switch (true) {
            case $_SERVER['REDIRECT_URL'] == '/links' && $_SERVER['REQUEST_METHOD'] == 'GET':
                $getListHandler = new GetLinks($mysql);
                $getListHandler->handle();
                break;
            case $_SERVER['REDIRECT_URL'] == '/link/create' && $_SERVER['REQUEST_METHOD'] == 'POST':
                header("Access-Control-Allow-Origin: *");
                header("Access-Control-Allow-Methods: POST");
                header("Access-Control-Request-Method: POST");
                header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin");
                $shortLinkHandler = new CreateLink($linksRepository, $redis, $AMQPChannel);
                $shortLinkHandler->handle();
                break;
            case strlen($_SERVER['REDIRECT_URL']) == 9 && $_SERVER['REQUEST_METHOD'] == 'GET':
                $tryRedirect = new Redirect($mysql);
                $tryRedirect->handle();
                break;
            case $_SERVER['REQUEST_METHOD'] == 'OPTIONS':
                header("Access-Control-Allow-Origin: *");
                header("Access-Control-Allow-Methods: POST");
                header("Access-Control-Request-Method: POST");
                header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin");
                break;
            default:
                $notFoundHandler = new NotFound();
                $notFoundHandler->handle();
                break;
        }

        $mysql->close();

        $redis->close();

        $AMQPChannel->close();
        $AMQPConnection->close();
    }
}