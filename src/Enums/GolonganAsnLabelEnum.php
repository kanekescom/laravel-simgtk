<?php

namespace Kanekescom\Simgtk\Enums;

use Filament\Support\Contracts\HasLabel;

enum GolonganAsnLabelEnum: string implements HasLabel
{
    case GOLONGAN11 = 'I/a';
    case GOLONGAN12 = 'I/b';
    case GOLONGAN13 = 'I/c';
    case GOLONGAN14 = 'I/d';
    case GOLONGAN21 = 'II/a';
    case GOLONGAN22 = 'II/b';
    case GOLONGAN23 = 'II/c';
    case GOLONGAN24 = 'II/d';
    case GOLONGAN31 = 'III/a';
    case GOLONGAN32 = 'III/b';
    case GOLONGAN33 = 'III/c';
    case GOLONGAN34 = 'III/d';
    case GOLONGAN41 = 'IV/a';
    case GOLONGAN42 = 'IV/b';
    case GOLONGAN43 = 'IV/c';
    case GOLONGAN44 = 'IV/d';
    case GOLONGAN45 = 'IV/e';

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
