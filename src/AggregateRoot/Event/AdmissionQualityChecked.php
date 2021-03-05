<?php

declare(strict_types=1);

namespace App\AggregateRoot\Event;

use App\AggregateRoot\AdmissionId;

class AdmissionQualityChecked extends AdmissionEvent
{
    public function __construct(AdmissionId $admissionId)
    {
        parent::__construct($admissionId);
    }

    public static function deserialize(array $data): self
    {
        return new self(
            new AdmissionId($data['admissionId'])
        );
    }
}
