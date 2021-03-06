<?php

declare(strict_types=1);

namespace App\AggregateRoot\ValueObject;

use Broadway\Serializer\Serializable;

class Artist implements Serializable
{
    private string $id;
    private int $externalId;
    private string $status;

    public function __construct(string $id, int $externalId, string $status)
    {
        $this->id = $id;
        $this->externalId = $externalId;
        $this->status = $status;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function externalId(): int
    {
        return $this->externalId;
    }

    public function status(): string
    {
        return $this->status;
    }

    public static function deserialize(array $data): self
    {
        return new self(
            $data['id'],
            $data['externalId'],
            $data['status']
        );
    }

    public function serialize(): array
    {
        return [
            'id' => $this->id,
            'externalId' => $this->externalId,
            'status' => $this->status
        ];
    }
}
