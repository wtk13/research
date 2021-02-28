<?php

declare(strict_types=1);

namespace App\AggregateRoot\Event;

use App\AggregateRoot\ArtistId;
use Broadway\Serializer\Serializable;

abstract class ArtistEvent implements Serializable
{
    private ArtistId $artistId;

    public function __construct(ArtistId $artistId)
    {
        $this->artistId = $artistId;
    }

    public function artistId(): ArtistId
    {
        return $this->artistId;
    }

    public function serialize(): array
    {
        return ['artistId' => (string) $this->artistId];
    }
}
