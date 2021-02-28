<?php

namespace App\Tests\Message;

use App\AggregateRoot\ArtistId;
use App\AggregateRoot\Event\ArtistCreated;
use App\Message\CreateArtist;

class CreateArtistTest extends ArtistCommandHandlerTest
{
    public function testItCreatesArtist(): void
    {
        $artistId = new ArtistId('00000000-0000-0000-0000-000000000000');
        $this->scenario
            ->given([])
            ->when(new CreateArtist())
            ->then([
               new ArtistCreated($artistId),
            ]);
    }
}
