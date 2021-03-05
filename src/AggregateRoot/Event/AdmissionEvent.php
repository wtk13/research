<?php

declare(strict_types=1);

namespace App\AggregateRoot\Event;

use App\AggregateRoot\AdmissionId;
use Broadway\Serializer\Serializable;

abstract class AdmissionEvent implements Serializable
{
    private AdmissionId $admissionId;

    public function __construct(AdmissionId $admissionId)
    {
        $this->admissionId = $admissionId;
    }

    public function admissionId(): AdmissionId
    {
        return $this->admissionId;
    }

    public function serialize(): array
    {
        return ['admissionId' => (string) $this->admissionId];
    }
}
