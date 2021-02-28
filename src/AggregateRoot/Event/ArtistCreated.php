<?php

declare(strict_types=1);

namespace App\AggregateRoot\Event;

use App\AggregateRoot\ArtistId;

class ArtistCreated extends ArtistEvent
{
    public function __construct(ArtistId $artistId)
    {
        parent::__construct($artistId);
    }

    public static function deserialize(array $data): self
    {
        return new self(new ArtistId($data['artistId']));
    }
}
