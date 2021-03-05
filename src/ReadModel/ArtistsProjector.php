<?php

declare(strict_types=1);

namespace App\ReadModel;

use App\AggregateRoot\Event\AdmissionQualityChecked;
use App\AggregateRoot\ValueObject\Artist;
use Broadway\ReadModel\Projector;
use Broadway\ReadModel\Repository;

class ArtistsProjector extends Projector
{
    private Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    protected function applyAdmissionQualityChecked(AdmissionQualityChecked $event)
    {
        $artist = $event->artist();

        $readModel = $this->getReadModel($artist);
        $readModel->incrementCounter();

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
}
