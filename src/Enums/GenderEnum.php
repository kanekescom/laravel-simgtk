<?php

namespace Kanekescom\Simgtk\Enums;

use Filament\Support\Contracts\HasLabel;

enum GenderEnum: string implements HasLabel
{
    case LAKILAKI = 'l';
    case PEREMPUAN = 'p';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::LAKILAKI => 'Laki-Laki',
            self::PEREMPUAN => 'Perempuan',
        };
    }
}
