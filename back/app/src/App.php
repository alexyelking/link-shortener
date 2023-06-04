<?php

namespace Shortener;

use Redis;

class App
{
    public function run()
    {
        $db = new Database();
        $conn = $db->connect();

        $redis = new Redis();
        $redis->connect('redis', 6379);
        $redis->select(1);

        switch (true) {
            case $_SERVER['REDIRECT_URL'] == '/links' && $_SERVER['REQUEST_METHOD'] == 'GET':
                $getListHandler = new GetLists($conn);
                $getListHandler->handle();
                break;
            case $_SERVER['REDIRECT_URL'] == '/link/create' && $_SERVER['REQUEST_METHOD'] == 'POST':
                header("Access-Control-Allow-Origin: *");
                header("Access-Control-Allow-Methods: POST");
                header("Access-Control-Request-Method: POST");
                header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin");
                $shortLinkHandler = new CreateShortLink($conn, $redis);
                $shortLinkHandler->handle();
                break;
            case strlen($_SERVER['REDIRECT_URL']) == 9 && $_SERVER['REQUEST_METHOD'] == 'GET':
                $tryRedirect = new Redirect($conn);
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

        $conn->close();
    }
}