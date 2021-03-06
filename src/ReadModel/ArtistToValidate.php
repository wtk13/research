<?php

declare(strict_types=1);

namespace App\ReadModel;

use Broadway\ReadModel\Identifiable;

class ArtistToValidate implements Identifiable
{
    private string $artistId;
    private int $externalId;
    private string $status;
    private int $count = 0;

    public function __construct(string $artistId, int $externalId, string $status)
    {
        $this->artistId = $artistId;
        $this->externalId = $externalId;
        $this->status = $status;
    }

    public function getId(): string
    {
       return $this->artistId;
    }

    public function externalId(): int
    {
        return $this->externalId;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function count(): int
    {
        return $this->count;
    }

    public function incrementCounter(): void
    {
        $this->count++;
    }
}
