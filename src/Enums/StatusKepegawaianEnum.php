<?php

namespace Kanekescom\Simgtk\Enums;

use Filament\Support\Contracts\HasLabel;

enum StatusKepegawaianEnum: string implements HasLabel
{
    case PNS = 'pns';
    case PPPK = 'pppk';
    case NONASN = 'nonasn';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PNS => 'PNS',
            self::PPPK => 'PPPK',
            self::NONASN => 'NONASN',
        };
    }
}
