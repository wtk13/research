<?php

declare(strict_types=1);

namespace App\AggregateRoot\Event;

use App\AggregateRoot\AdmissionId;
use App\AggregateRoot\ValueObject\Artist;

class AdmissionQualityChecked extends AdmissionEvent
{
    private Artist $artist;

    public function __construct(AdmissionId $admissionId, Artist $artist)
    {
        parent::__construct($admissionId);
        $this->artist = $artist;
    }

    public static function deserialize(array $data): self
    {
        return new self(
            new AdmissionId($data['admissionId']),
            unserialize($data['artist'], [
                'allowed_classes' => [Artist::class]
            ])
        );
    }

    public function serialize(): array
    {
        return ['admissionId' => (string) $this->admissionId(), 'artist' => serialize($this->artist)];
    }

    public function artist(): Artist
    {
        return $this->artist;
    }
}
