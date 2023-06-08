<?php

namespace Shortener\Controllers;

use mysqli;
use Shortener\Repositories\LinkRepository;

class Redirect
{
    private LinkRepository $links;

    public function __construct(LinkRepository $links)
    {
        $this->links = $links;
    }

    public function tryRedirect(): void
    {
        $short = mb_substr($_SERVER['REDIRECT_URL'], 1);

        $source = $this->links->getLinkByShort($short);

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