<?php

declare(strict_types=1);

namespace App\AggregateRoot\Event;

use App\AggregateRoot\ArtistId;

class ArtistMadeVip extends ArtistEvent
{
    private string $status;

    public function __construct(ArtistId $artistId, string $status)
    {
        $this->status = $status;

        parent::__construct($artistId);
    }

    public function serialize(): array
    {
        return array_merge(parent::serialize(), [
            'status' => $this->status
        ]);
    }

    public static function deserialize(array $data)
    {
        return new self(
            new ArtistId($data['artistId']),
            $data['status']
        );
    }
}
