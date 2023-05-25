<?php

namespace Shortener;

use mysqli;

class CreateShortLink
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    public function handle()
    {
        if (!empty($_POST['source'])) {
            $source = $_POST['source'];

            $uniq = uniqid();
            $short = "";

            $supplement = time();
            $supplementValue = "";

            for ($i = 0; $i < 4; $i++) {

                $short .= $uniq[rand(0, 12)];

                $supVal = $supplement % (rand(1, 10));
                $supplementValue .= $supVal;
            }

            $short .= $supplementValue;

            $sql = "INSERT INTO links (source, short) VALUES (?, ?)";
            $statement = $this->db->prepare($sql);
            $statement->bind_param("ss", $source, $short);
            $statement->execute();

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                "message" => "Create successful",
                "data" => [
                    "short" => $short,
                    "link" => 'http://' . $_SERVER['HTTP_HOST'] . '/' . $short
                ]
            ]);
        } else {
            http_response_code(422);
            echo "Source link is required";
        }
    }
}