<?php

namespace Shortener;

class App
{
    public function run()
    {
        $db = new Database();
        $conn = $db->connect();
        switch (true) {

            case $_SERVER['PATH_INFO'] == '/links' && $_SERVER['REQUEST_METHOD'] == 'GET':
                $getListHandler = new GetLists($conn);
                $getListHandler->handle();
                break;
            case $_SERVER['PATH_INFO'] == '/link/create' && $_SERVER['REQUEST_METHOD'] == 'GET':
                $shortLinkHandler = new CreateShortLink($conn);
                $shortLinkHandler->handle();
                break;
            case  strlen($_SERVER['PATH_INFO']) == 9 && $_SERVER['REQUEST_METHOD'] == 'GET':
                $tryRedirect = new Redirect($conn);
                $tryRedirect->handle();
                break;
            default:
                $notFoundHandler = new NotFound();
                $notFoundHandler->handle();
                break;
        }

        $conn->close();
    }
}
