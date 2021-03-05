<?php

declare(strict_types=1);

namespace App\AggregateRoot\Event;

use App\AggregateRoot\ArtistId;

class ArtistCreated extends ArtistEvent
{
    private string $status;
    private int $externalId;

    public function __construct(ArtistId $artistId, int $externalId, string $status)
    {
        $this->status = $status;
        $this->externalId = $externalId;

        parent::__construct($artistId);
    }

    public static function deserialize(array $data): self
    {
        return new self(
            new ArtistId(
                $data['artistId']
            ),
            $data['externalId'],
            $data['status']
        );
    }

    public function status(): string
    {
        return $this->status;
    }

    public function externalId(): int
    {
        return $this->externalId;
    }

    public function serialize(): array
    {
        return [
            'artistId' => (string) $this->artistId(),
            'externalId' => $this->externalId,
            'status' => $this->status,
        ];
    }
}
