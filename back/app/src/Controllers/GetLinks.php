<?php

namespace Shortener\Controllers;

use PhpAmqpLib\Message\AMQPMessage;
use Shortener\Configs\AMQPConfig;
use Shortener\Configs\Config;
use Shortener\Configs\DatabaseConfig;
use Shortener\Configs\RedisConfig;
use Shortener\Configs\TelegramConfig;
use Shortener\Repositories\LinkRepository;

class GetLinks
{
    private LinkRepository $links;
    private int $limit;
    private int $offset;
    private array $data;

    public function __construct(LinkRepository $links)
    {
        $this->links = $links;
        $this->limit = $_GET['limit'] ?? 10;
        $this->offset = $_GET['offset'] ?? 0;
    }

    public function getLinks(): void
    {
        $links = $this->links->getLinks($this->limit, $this->offset);

        if ($links->num_rows) {
            foreach ($links as $link) {
                $this->data[] = [
                    'id' => $link["id"],
                    'source' => $link["source"],
                    'short' => 'http://' . $_SERVER['HTTP_HOST'] . '/' . $link["short"]
                ];
            }
            echo json_encode([
                "message" => 'Result found',
                "data" => $this->data]);
        } else
            echo json_encode([
                "message" => "No results found",
            ]);
    }
}