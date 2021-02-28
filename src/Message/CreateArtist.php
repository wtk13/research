<?php

namespace App\Message;

use App\AggregateRoot\ArtistId;

final class CreateArtist
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
}
