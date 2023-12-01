<?php

namespace Kanekescom\Simgtk\Filament\Resources\SekolahResource\Pages;

use Kanekescom\Simgtk\Filament\Resources\SekolahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSekolahs extends ListRecords
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
