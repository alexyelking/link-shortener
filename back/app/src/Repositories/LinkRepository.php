<?php

namespace Shortener\Repositories;

use mysqli;
use Shortener\Models\Link;

class LinkRepository
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    public function create(string $source): Link
    {
        $short = $this->generateUniqID();

        $sql = "INSERT INTO links (source, short) VALUES (?, ?)";

        $statement = $this->db->prepare($sql);
        $statement->bind_param("ss", $source, $short);
        $statement->execute();

        $link = $this->getLinkByShort($short);

        if (empty($link)) {
            throw new \Exception('Link not found');
        }

        return new Link($link['id'], $link['source'], $link['short'], $link['created_at']);
    }

    public function getLinks(int $limit, int $offset): bool|\mysqli_result
    {
        $sql = "SELECT * FROM links LIMIT ? OFFSET ?";

        $statement = $this->db->prepare($sql);
        $statement->bind_param("ii", $limit, $offset);
        $statement->execute();

        return $statement->get_result();
    }

    public function getLinkByShort(string $short): bool|array|null
    {
        $sql = "SELECT * FROM links WHERE short=?";

        $statement = $this->db->prepare($sql);
        $statement->bind_param("s", $short);
        $statement->execute();
        $result = $statement->get_result();

        return $result->fetch_assoc();
    }

    public function generateUniqID(): string
    {
        $uniqValue = uniqid();
        $uniqString = "";

        $timeValue = time();

        $supplementString = "";

        for ($i = 0; $i < 4; $i++) {
            $uniqString .= $uniqValue[rand(0, 12)];
            $supplementValue = $timeValue % (rand(1, 10));
            $supplementString .= $supplementValue;
        }
        $uniqString .= $supplementString;
        return $uniqString;
    }
}