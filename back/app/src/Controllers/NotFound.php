<?php

namespace Shortener\Controllers;

class NotFound
{
    public function handle()
    {
        http_response_code(404);
        echo 'Not Found';
    }
}