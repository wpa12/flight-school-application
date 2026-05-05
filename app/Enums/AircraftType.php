<?php

declare(strict_types=1);

namespace App\Enums;

enum AircraftType: string
{
    case SINGLE = 'single';
    case MULTI = 'multi';
    case JET = 'jet';
    case TWINJET = 'twinjet';
    case TURBOPROP = 'turboprop';
    case TWINTURBOPROP = 'twinturboprop';

    public function label(): string
    {
        return match ($this) {
            self::SINGLE => 'Single',
            self::MULTI => 'Multi',
            self::JET => 'Jet',
            self::TWINJET => 'Twinjet',
            self::TURBOPROP => 'Turboprop',
            self::TWINTURBOPROP => 'Twinturboprop',
        };
    }
}