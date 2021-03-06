<?php

declare(strict_types=1);

namespace App\ReadModel;

use App\AggregateRoot\Event\AdmissionQualityChecked;
use Broadway\ReadModel\Projector;
use Broadway\ReadModel\Repository;

class AdmissionProjector extends Projector
{
    private Repository $repository;

    public function __construct(Repository $admissionToValidateRepository)
    {
        $this->repository = $admissionToValidateRepository;
    }

    protected function applyAdmissionQualityChecked(AdmissionQualityChecked $event): void
    {
        $readModel = $this->getReadModel($event);

        $this->repository->save($readModel);
    }

    private function getReadModel(AdmissionQualityChecked $event): AdmissionToValidate
    {
        $readModel = $this->repository->find($event->admissionId()->__toString());

        if ($readModel) {
            throw new \LogicException();
        }

        return new AdmissionToValidate(
            $event->admissionId()->__toString(),
            $event->externalId(),
            $event->artist()->externalId()
        );
    }
}
