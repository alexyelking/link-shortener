<?php

namespace Shortener;

use mysqli;

class GetLists
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
        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "id: " . $row["id"] . " - Source: " . $row["source"] . " - Short: " . $row["short"] . "\n";
            }
        } else {
            echo "0 results\n";
        }
    }
}