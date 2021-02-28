<?php

declare(strict_types=1);

namespace App\AggregateRoot;

final class ArtistId
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
