<?php

namespace Shortener\Controllers;

class NotFound
{
    public function throw(): void
    {
        http_response_code(404);
        echo json_encode([
            "message" => "Link not found",
        ]);
    }
}