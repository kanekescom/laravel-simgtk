<?php

namespace Kanekescom\Simgtk\Filament\Resources\JenjangSekolahResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\JenjangSekolahResource;

class ListJenjangSekolah extends ListRecords
{
    protected static string $resource = JenjangSekolahResource::class;

    protected static ?string $title = 'Jenjang Sekolah';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make()->label('Create'),
        ];
    }
}
