<?php

namespace Kanekescom\Simgtk\Filament\Resources\PegawaiPppkResource\Pages;

use Kanekescom\Simgtk\Filament\Resources\PegawaiPppkResource;
use Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Pages\ListPegawai;

class ListPegawaiPppk extends ListPegawai
{
    protected static string $resource = PegawaiPppkResource::class;

    protected static ?string $title = 'Pegawai PPPK';

    public function getTabs(): array
    {
        return [];
    }
}
