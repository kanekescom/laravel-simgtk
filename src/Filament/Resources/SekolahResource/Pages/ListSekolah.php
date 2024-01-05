<?php

namespace Kanekescom\Simgtk\Filament\Resources\SekolahResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\SekolahResource;

class ListSekolah extends ListRecords
{
    protected static string $resource = SekolahResource::class;

    protected static ?string $title = 'Sekolah';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
