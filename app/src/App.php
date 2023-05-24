<?php

namespace Shortener;

class App {
    public function run()
    {
        $db = new Db();
        $conn = $db->connect();

        switch(true) {
            case $_SERVER['PATH_INFO'] == '/links' && $_SERVER['REQUEST_METHOD'] == 'GET':
                $getListHandler = new GetList($conn);
                $getListHandler->handle();
                break;
            default:
                $notFoundHandler = new NotFound();
                $notFoundHandler->handle();
                break;
        }

        $conn->close();
    }
}
