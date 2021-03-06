<?php

declare(strict_types=1);

namespace App\AggregateRoot;

use App\AggregateRoot\Enum\AdmissionStatus;
use App\AggregateRoot\Event\AdmissionQualityChecked;
use App\AggregateRoot\ValueObject\Artwork;
use Broadway\EventSourcing\SimpleEventSourcedEntity;

class Admission extends SimpleEventSourcedEntity
{
    private AdmissionId $id;
    private ArtistId $artistId;
    private int $externalId;
    private string $status;
    private string $title;

    public function __construct(
        AdmissionId $id,
        ArtistId $artistId,
        Artwork $artwork
    ) {
        $this->id = $id;
        $this->title = $artwork->title();
        $this->artistId = $artistId;
        $this->externalId = $artwork->externalId();

        $this->status = AdmissionStatus::QUALITY_CHECKED()->getValue();
    }

    public function getAggregateRootId(): string
    {
        return (string) $this->id;
    }

    public function checkQuality(\App\AggregateRoot\ValueObject\Artist $artist): void
    {
        if (
            !in_array($this->status, [
                AdmissionStatus::WAITING_FOR_VALIDATION()->getValue(),
                AdmissionStatus::QUALITY_CHECKED()->getValue()
            ])
        ) {
            throw new \InvalidArgumentException();
        }

        $this->apply(new AdmissionQualityChecked($this->id, $artist));
    }

    public function applyAdmissionQualityChecked(AdmissionQualityChecked $event): void
    {
        $this->status = AdmissionStatus::QUALITY_CHECKED()->getValue();
    }
}
