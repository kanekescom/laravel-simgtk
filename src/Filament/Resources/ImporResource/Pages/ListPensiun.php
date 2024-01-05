<?php

namespace Kanekescom\Simgtk\Filament\Resources\ImporResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\ImporResource;

class ListImpor extends ListRecords
{
    protected static string $resource = ImporResource::class;

    protected static ?string $title = 'Impor';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
