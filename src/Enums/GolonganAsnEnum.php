<?php

namespace Kanekescom\Simgtk\Enums;

use Filament\Support\Contracts\HasLabel;

enum GolonganAsnEnum: string implements HasLabel
{
    case GOLONGAN11 = '11';
    case GOLONGAN12 = '12';
    case GOLONGAN13 = '13';
    case GOLONGAN14 = '14';
    case GOLONGAN21 = '21';
    case GOLONGAN22 = '22';
    case GOLONGAN23 = '23';
    case GOLONGAN24 = '24';
    case GOLONGAN31 = '31';
    case GOLONGAN32 = '32';
    case GOLONGAN33 = '33';
    case GOLONGAN34 = '34';
    case GOLONGAN41 = '41';
    case GOLONGAN42 = '42';
    case GOLONGAN43 = '43';
    case GOLONGAN44 = '44';
    case GOLONGAN45 = '45';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::GOLONGAN11 => 'I/a Juru Muda',
            self::GOLONGAN12 => 'I/b Juru Muda Tingkat I',
            self::GOLONGAN13 => 'I/c Juru',
            self::GOLONGAN14 => 'I/d Juru Tingkat I',
            self::GOLONGAN21 => 'II/a Pengatur Muda',
            self::GOLONGAN22 => 'II/b Pengatur Muda Tingkat I',
            self::GOLONGAN23 => 'II/c Pengatur',
            self::GOLONGAN24 => 'II/d Pengatur Tingkat I',
            self::GOLONGAN31 => 'III/a Penata Muda',
            self::GOLONGAN32 => 'III/b Penata Muda Tingkat I',
            self::GOLONGAN33 => 'III/c Penata',
            self::GOLONGAN34 => 'III/d Penata Tingkat I',
            self::GOLONGAN41 => 'IV/a Pembina',
            self::GOLONGAN42 => 'IV/b Pembina Tingkat I',
            self::GOLONGAN43 => 'IV/c Pembina Utama Muda',
            self::GOLONGAN44 => 'IV/d Pembina Utama Madya',
            self::GOLONGAN45 => 'IV/e Pembina Utama',
        };
    }
}
