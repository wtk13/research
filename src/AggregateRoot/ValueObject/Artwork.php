<?php

declare(strict_types=1);

namespace App\AggregateRoot\ValueObject;

use Broadway\Serializer\Serializable;

class Artwork implements Serializable
{
    private int $externalId;
    private string $title;

    public function __construct(int $externalId, string $title)
    {
        $this->externalId = $externalId;
        $this->title = $title;
    }

    public function externalId(): int
    {
        return $this->externalId;
    }

    public function title(): string
    {
        return $this->title;
    }

    public static function deserialize(array $data): self
    {
        return new self(
            $data['externalId'],
            $data['title']
        );
    }

    public function serialize(): array
    {
        return [
            'externalId' => $this->externalId,
            'title' => $this->title
        ];
    }
}
