<?php

namespace Shortener\Repositories;

use mysqli;
use Shortener\Models\Link;

class LinkRepository
{
    private mysqli $db;

    /**
     * @param mysqli $db
     */
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

        $id = $statement->insert_id;
        $statement = $this->db->query("SELECT * FROM links WHERE id=$id LIMIT 1");
        $link = $statement->fetch_assoc();

        if(empty($link)) {
            throw new \Exception('Не смог найти запись');
        }

        return new Link($link['id'], $link['source'], $link['short'], $link['created_at']);
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