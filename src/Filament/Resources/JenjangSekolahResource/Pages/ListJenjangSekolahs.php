<?php

namespace Kanekescom\Simgtk\Filament\Resources\JenjangSekolahResource\Pages;

use Kanekescom\Simgtk\Filament\Resources\JenjangSekolahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJenjangSekolahs extends ListRecords
{
    protected static string $resource = JenjangSekolahResource::class;

    protected static ?string $title = 'Jenjang Sekolah';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
