<?php
require_once 'db.php';
require_once 'get-list.php';
$db = new MysqliDatabase();
$conn = $db->connect();

$getListHandler = new GetList($conn);
$getListHandler->handle();

$conn->close();