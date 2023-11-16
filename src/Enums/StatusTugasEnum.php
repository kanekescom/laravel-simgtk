<?php

namespace Kanekescom\Simgtk\Enums;

use Filament\Support\Contracts\HasLabel;

enum StatusTugasEnum: string implements HasLabel
{
    case INDUK = 'induk';
    case CABANG = 'cabang';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::INDUK => 'Induk',
            self::CABANG => 'Cabang',
        };
    }
}
