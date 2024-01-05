<?php

namespace Kanekescom\Simgtk\Filament\Resources\PensiunResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\PensiunResource;

class ListPensiun extends ListRecords
{
    protected static string $resource = PensiunResource::class;

    protected static ?string $title = 'Pensiun';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
