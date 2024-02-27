<?php

namespace Kanekescom\Simgtk\Enums;

use Filament\Support\Contracts\HasLabel;

enum JenjangPendidikanLabelEnum: string implements HasLabel
{
    case SD = 'SD / sederajat';
    case PAKETA = 'Paket A';
    case SMP = 'SMP / sederajat';
    case PAKETB = 'Paket B';
    case SMA = 'SMA / sederajat';
    case PAKETC = 'Paket C';
    case D1 = 'D1';
    case D2 = 'D2';
    case D3 = 'D3';
    case D4 = 'D4';
    case S1 = 'S1';
    case S2 = 'S2';
    case S3 = 'S3';
    case PROFESI = 'Profesi';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SD => 'SD / sederajat',
            self::PAKETA => 'Paket A',
            self::SMP => 'SMP / sederajat',
            self::PAKETB => 'Paket B',
            self::SMA => 'SMA / sederajat',
            self::PAKETC => 'Paket C',
            self::D1 => 'D1',
            self::D2 => 'D2',
            self::D3 => 'D3',
            self::D4 => 'D4',
            self::S1 => 'S1',
            self::S2 => 'S2',
            self::S3 => 'S3',
            self::PROFESI => 'Profesi',
        };
    }
}
