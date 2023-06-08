<?php

namespace Shortener\Controllers;

use mysqli;

class GetLinks
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    public function handle()
    {
        $limit = empty($_GET['limit']) ? 100 : $_GET['limit'];
        $offset = empty($_GET['offset']) ? 0 : $_GET['offset'];

        $sql = "SELECT * FROM links LIMIT ? OFFSET ?";
        $statement = $this->db->prepare($sql);
        $statement->bind_param("ii", $limit, $offset);
        $statement->execute();
        $links = $statement->get_result();

        header('Content-Type: application/json; charset=utf-8');
        if ($links->num_rows > 0) {
            foreach ($links as $link) {
                $data[] = [
                    'id' => $link["id"],
                    'source' => $link["source"],
                    'short' => 'http://' . $_SERVER['HTTP_HOST'] . '/' . $link["short"]
                ];
            }
            echo json_encode($data);
        } else
            echo json_encode([
                "message" => "No results found",
            ]);
    }
}