<?php

declare(strict_types=1);

namespace App\AggregateRoot\Event;

use App\AggregateRoot\ArtistId;

class ArtistCreated extends ArtistEvent
{
    private string $status;

    public function __construct(ArtistId $artistId, string $status)
    {
        parent::__construct($artistId);
        $this->status = $status;
    }

    public static function deserialize(array $data): self
    {
        return new self(
            new ArtistId(
                $data['artistId']
            ),
            $data['status']
        );
    }

    public function status(): string
    {
        return $this->status;
    }

    public function serialize(): array
    {
        return [
            'artistId' => (string) $this->artistId(),
            'status' => $this->status,
        ];
    }
}
