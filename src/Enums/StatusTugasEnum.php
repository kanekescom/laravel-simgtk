<?php

namespace Kanekescom\Simgtk\Enums;

use Filament\Support\Contracts\HasLabel;

enum StatusTugasEnum: string implements HasLabel
{
    case INDUK = 'induk';
    case NONINDUK = 'noninduk';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::INDUK => 'Induk',
            self::NONINDUK => 'Non Induk',
        };
    }
}
