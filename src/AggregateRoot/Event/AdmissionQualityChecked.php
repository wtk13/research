<?php

declare(strict_types=1);

namespace App\AggregateRoot\Event;

use App\AggregateRoot\AdmissionId;
use App\AggregateRoot\ValueObject\Artist;

class AdmissionQualityChecked extends AdmissionEvent
{
    private Artist $artist;
    private int $externalId;

    public function __construct(AdmissionId $admissionId, Artist $artist, int $externalId)
    {
        $this->artist = $artist;
        $this->externalId = $externalId;

        parent::__construct($admissionId);
    }

    public static function deserialize(array $data): self
    {
        return new self(
            new AdmissionId($data['admissionId']),
            unserialize($data['artist'], [
                'allowed_classes' => [Artist::class]
            ]),
            $data['externalId']
        );
    }

    public function serialize(): array
    {
        return [
            'admissionId' => (string) $this->admissionId(),
            'artist' => serialize($this->artist),
            'externalId' => $this->externalId
        ];
    }

    public function artist(): Artist
    {
        return $this->artist;
    }

    public function externalId(): int
    {
        return $this->externalId;
    }
}
