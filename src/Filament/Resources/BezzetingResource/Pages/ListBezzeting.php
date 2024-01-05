<?php

namespace Kanekescom\Simgtk\Filament\Resources\BezzetingResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\BezzetingResource;

class ListBezzeting extends ListRecords
{
    protected static string $resource = BezzetingResource::class;

    protected static ?string $title = 'Bezzeting';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
