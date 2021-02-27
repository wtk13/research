<?php

declare(strict_types=1);

namespace App\AggregateRoot;

class ArtistId
{
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
