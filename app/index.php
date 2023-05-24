<?php
require_once 'db.php';
require_once 'get-list.php';
require_once 'not-found.php';
$db = new MysqliDatabase();
$conn = $db->connect();

switch($_SERVER['PATH_INFO']) {
    case '/links':
        $getListHandler = new GetList($conn);
        $getListHandler->handle();
        break;
    default:
        $notFoundHandler = new NotFound();
        $notFoundHandler->handle();
        break;
}

$conn->close();