<?php

namespace Kanekescom\Simgtk\Filament\Resources\PegawaiNonAsnResource\Pages;

use Kanekescom\Simgtk\Filament\Resources\PegawaiNonAsnResource;
use Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Pages\ListPegawai;

class ListPegawaiNonAsn extends ListPegawai
{
    protected static string $resource = PegawaiNonAsnResource::class;

    protected static ?string $title = 'Pegawai NonASN';

    public function getTabs(): array
    {
        return [];
    }
}
