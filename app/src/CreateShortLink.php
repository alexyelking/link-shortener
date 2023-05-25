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
        if (!empty($_GET['source'])) {
            $source = $_GET['source'];

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
        } else echo "Source link is required";
    }
}