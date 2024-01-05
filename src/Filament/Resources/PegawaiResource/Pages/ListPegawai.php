<?php

namespace Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\PegawaiResource;

class ListPegawai extends ListRecords
{
    protected static string $resource = PegawaiResource::class;

    protected static ?string $title = 'Pegawai';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
