<?php

declare(strict_types=1);

namespace App\ReadModel;

use Broadway\ReadModel\SerializableReadModel;

class ArtistToValidate implements SerializableReadModel
{
    private string $artistId;
    private int $externalId;
    private string $status;
    private int $count;

    public function __construct(
        string $artistId,
        int $externalId,
        string $status,
        int $count = 0
    ) {
        $this->artistId = $artistId;
        $this->externalId = $externalId;
        $this->status = $status;
        $this->count = $count;
    }

    public function getId(): string
    {
       return $this->artistId;
    }

    public static function deserialize(array $data): self
    {
        return new self(
            $data['id'],
            $data['external_id'],
            $data['status'],
            $data['count'],
        );
    }

    public function serialize(): array
    {
        return [
            'id' => $this->artistId,
            'external_id' => $this->externalId,
            'status' => $this->status,
            'count' => $this->count
        ];
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
