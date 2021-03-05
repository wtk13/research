<?php

declare(strict_types=1);

namespace App\AggregateRoot\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self WAITING_FOR_VALIDATION()
 * @method static self QUALITY_CHECKED()
 */
class AdmissionStatus extends Enum
{
    private const WAITING_FOR_VALIDATION = 'waiting for validation';
    private const QUALITY_CHECKED = 'quality checked';
}
