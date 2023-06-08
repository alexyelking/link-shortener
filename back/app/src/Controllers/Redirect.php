<?php

namespace Shortener\Controllers;

use mysqli;

class Redirect
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    public function tryRedirect(): void
    {
        $short = mb_substr($_SERVER['REDIRECT_URL'], 1);
        $sql = "SELECT source FROM links WHERE short=?";
        $statement = $this->db->prepare($sql);
        $statement->bind_param("s", $short);
        $statement->execute();
        $result = $statement->get_result();
        $source = $result->fetch_assoc();
        if (!empty($source['source'])) {
            header('location: ' . $source['source']);
        } else {
            http_response_code(404);
            echo json_encode([
                "message" => "Link not found",
            ]);
        }
    }
}