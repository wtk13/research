<?php

declare(strict_types=1);

namespace App\AggregateRoot\Event;

use App\AggregateRoot\AdmissionId;
use App\AggregateRoot\ValueObject\Artwork;

class AdmissionWasAddedToArtist extends AdmissionEvent
{
    private Artwork $artwork;

    public function __construct(AdmissionId $admissionId, Artwork $artwork)
    {
        $this->artwork = $artwork;

        parent::__construct($admissionId);
    }

    public function artwork(): Artwork
    {
        return $this->artwork;
    }

    public static function deserialize(array $data): self
    {
        return new self(
            new AdmissionId($data['admissionId']),
            unserialize($data['artwork'], [
                'allowed_classes' => [Artwork::class]
            ])
        );
    }

    public function serialize(): array
    {
        return [
            'admissionId' => (string) $this->admissionId(),
            'artwork' => serialize($this->artwork)
        ];
    }
}
