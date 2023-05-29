<?php

namespace Shortener;
class App
{
    public function run()
    {
        $db = new Database();
        $conn = $db->connect();
//        var_dump($_SERVER);
        switch (true) {
            case $_SERVER['REDIRECT_URL'] == '/links' && $_SERVER['REQUEST_METHOD'] == 'GET':
                $getListHandler = new GetLists($conn);
                $getListHandler->handle();
                break;
            case $_SERVER['REDIRECT_URL'] == '/link/create' && $_SERVER['REQUEST_METHOD'] == 'POST':
                $shortLinkHandler = new CreateShortLink($conn);
                $shortLinkHandler->handle();
                break;
            case  strlen($_SERVER['REDIRECT_URL']) == 9 && $_SERVER['REQUEST_METHOD'] == 'GET':
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