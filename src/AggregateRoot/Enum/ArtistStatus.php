<?php

declare(strict_types=1);

namespace App\AggregateRoot\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self REGULAR()
 * @method static self VIP()
 * @method static self RISKY()
 */
class ArtistStatus extends Enum
{
    private const REGULAR = 'regular';
    private const VIP = 'vip';
    private const RISKY = 'risky';
}
