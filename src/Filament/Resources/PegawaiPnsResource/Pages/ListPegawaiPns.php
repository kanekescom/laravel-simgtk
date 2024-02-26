<?php

namespace Kanekescom\Simgtk\Filament\Resources\PegawaiPnsResource\Pages;

use Kanekescom\Simgtk\Filament\Resources\PegawaiPnsResource;
use Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Pages\ListPegawai;

class ListPegawaiPns extends ListPegawai
{
    protected static string $resource = PegawaiPnsResource::class;

    protected static ?string $title = 'Pegawai PNS';

    public function getTabs(): array
    {
        return [];
    }
}
