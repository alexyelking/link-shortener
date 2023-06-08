<?php

namespace Shortener\Models;

class Link
{
    public int $id;
    public string $source;
    public string $short;
    public string $created_at;


    /**
     * @param int $id
     * @param string $source
     * @param string $short
     * @param string $created_at
     */
    public function __construct(int $id, string $source, string $short, string $created_at)
    {
        $this->id = $id;
        $this->source = $source;
        $this->short = $short;
        $this->created_at = $created_at;
    }
}