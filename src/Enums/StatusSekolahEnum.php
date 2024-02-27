<?php

namespace Kanekescom\Simgtk\Enums;

use Filament\Support\Contracts\HasLabel;

enum StatusSekolahEnum: string implements HasLabel
{
    case NEGERI = 'negeri';
    case SWASTA = 'swasta';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::NEGERI => 'Negeri',
            self::SWASTA => 'Swasta',
        };
    }
}
