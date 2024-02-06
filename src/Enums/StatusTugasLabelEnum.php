<?php

namespace Kanekescom\Simgtk\Enums;

use Filament\Support\Contracts\HasLabel;

enum StatusTugasLabelEnum: string implements HasLabel
{
    case INDUK = 'Induk';
    case NONINDUK = 'Non Induk';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::INDUK => 'Induk',
            self::NONINDUK => 'Non Induk',
        };
    }
}
