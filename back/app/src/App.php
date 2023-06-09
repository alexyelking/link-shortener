<?php

namespace Shortener;

use Shortener\Controllers\GetLinks;
use Shortener\Controllers\NotFound;
use Shortener\Controllers\Redirect;
use Shortener\Controllers\CreateLink;
use Shortener\Infrastructure\DatabaseConnectionReturner;
use Shortener\Infrastructure\RedisConnectionReturner;
use Shortener\Repositories\LinkRepository;
use Shortener\Infrastructure\AMQPConnectionReturner;

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
        // DB connect
        $databaseConnection = new DatabaseConnectionReturner();
        $database = $databaseConnection->connect();

        $linksRepository = new LinkRepository($database);

        // Redis connect
        $redisConnection = new RedisConnectionReturner();
        $redis = $redisConnection->connect();

        // AMQP connect
        $AMQPConnection = new AMQPConnectionReturner();
        $AMQPChannel = $AMQPConnection->connect();

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
    }
}