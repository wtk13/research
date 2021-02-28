<?php

declare(strict_types=1);

namespace App\AggregateRoot;

use App\AggregateRoot\Event\ArtistCreated;
use App\AggregateRoot\Event\ArtistMadeVip;
use Broadway\EventSourcing\EventSourcedAggregateRoot;

class Artist extends EventSourcedAggregateRoot
{
    private ArtistId $id;
    private string $status = 'regular';

    public function getAggregateRootId(): string
    {
        return (string) $this->id;
    }

    public static function createArtist(ArtistId $artistId): Artist
    {
        $artist = new Artist();
        $artist->create($artistId);

        return $artist;
    }

    private function create(ArtistId $artistId): void
    {
        $this->apply(
            new ArtistCreated($artistId)
        );
    }

    protected function applyArtistCreated(ArtistCreated $event): void
    {
        $this->id = $event->artistId();
    }

    public function makeVip(): void
    {
        if ($this->status === 'vip') {
            return;
        }

        $this->apply(
            new ArtistMadeVip($this->id, $this->status)
        );
    }

    protected function applyArtistMadeVip(ArtistMadeVip $event): void
    {
        $this->status = 'vip';
    }
}
