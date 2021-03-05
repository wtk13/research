<?php

declare(strict_types=1);

namespace App\AggregateRoot;

use App\AggregateRoot\Enum\ArtistStatus;
use App\AggregateRoot\Event\AdmissionWasAddedToArtist;
use App\AggregateRoot\Event\ArtistCreated;
use App\AggregateRoot\Event\ChangedArtistStatus;
use App\AggregateRoot\ValueObject\Artwork;
use Broadway\EventSourcing\EventSourcedAggregateRoot;

class Artist extends EventSourcedAggregateRoot
{
    private ArtistId $id;
    private string $status;
    private int $externalId;

    /** @var Admission[] */
    private array $admissionIds = [];

    public function getAggregateRootId(): string
    {
        return (string) $this->id;
    }

    public static function createArtist(ArtistId $artistId, int $externalId): Artist
    {
        $artist = new Artist();
        $artist->create($artistId, $externalId, ArtistStatus::REGULAR());

        return $artist;
    }

    private function create(ArtistId $artistId, int $externalId, ArtistStatus $status): void
    {
        $this->apply(
            new ArtistCreated(
                $artistId,
                $externalId,
                $status->getValue()
            )
        );
    }

    public function applyArtistCreated(ArtistCreated $event): void
    {
        $this->id = $event->artistId();
        $this->status = $event->status();
        $this->externalId = $event->externalId();
    }

    public function changeStatus(ArtistStatus $status): void
    {
        if ($this->status === $status->getValue()) {
            return;
        }

        $this->apply(
            new ChangedArtistStatus($this->id, $status->getValue())
        );
    }

    public function applyChangedArtistStatus(ChangedArtistStatus $event): void
    {
        $this->status = $event->status();
    }

    public function addAdmission(AdmissionId $admissionId, Artwork $artwork): void
    {
        if (array_key_exists($admissionId->__toString(), $this->admissionIds)) {
            throw new \InvalidArgumentException();
        }

        $this->apply(
            new AdmissionWasAddedToArtist($admissionId, $artwork)
        );
    }

    public function applyAdmissionWasAddedToArtist(AdmissionWasAddedToArtist $event)
    {
        $this->admissionIds[$event->admissionId()->__toString()] = new Admission(
            $event->admissionId(),
            $this->id,
            $event->artwork()
        );
    }

    public function checkAdmissionQuality(AdmissionId $admissionId): void
    {
        if (!array_key_exists($admissionId->__toString(), $this->admissionIds)) {
            throw new \InvalidArgumentException();
        }

        $this->admissionIds[$admissionId->__toString()]->checkQuality();
    }

    protected function getChildEntities(): array
    {
        return $this->admissionIds;
    }
}
