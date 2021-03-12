<?php

declare(strict_types=1);

namespace App\ReadModel;

use App\AggregateRoot\ArtistId;
use App\AggregateRoot\Event\AdmissionQualityChecked;
use App\AggregateRoot\Event\ChangedArtistStatus;
use App\AggregateRoot\ValueObject\Artist;
use Broadway\ReadModel\Projector;
use Broadway\ReadModel\Repository;

class ArtistsProjector extends Projector
{
    private Repository $repository;

    public function __construct(Repository $artistToValidateRepository)
    {
        $this->repository = $artistToValidateRepository;
    }

    protected function applyAdmissionQualityChecked(AdmissionQualityChecked $event): void
    {
        $artist = $event->artist();

        $readModel = $this->getReadModel($artist);
        $readModel->incrementCounter();

        $this->repository->save($readModel);
    }

    protected function applyChangedArtistStatus(ChangedArtistStatus $event): void
    {
        $artist = $event->artistId();

        $readModel = $this->getReadModelById($artist);

        if (null === $readModel) {
            return;
        }

        $readModel->changeStatus($event->status());

        $this->repository->save($readModel);
    }

    private function getReadModel(Artist $artist): ArtistToValidate
    {
        $readModel = $this->repository->find($artist->id());

        if (null === $readModel) {
            $readModel = new ArtistToValidate($artist->id(), $artist->externalId(), $artist->status());
        }

        return $readModel;
    }

    private function getReadModelById(ArtistId $artistId): ?ArtistToValidate
    {
        $readModel = $this->repository->find($artistId->__toString());

        if (null === $readModel) {
            return null;
        }

        return $readModel;
    }
}
