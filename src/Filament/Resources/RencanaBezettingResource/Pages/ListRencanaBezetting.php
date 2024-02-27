<?php

namespace Kanekescom\Simgtk\Filament\Resources\RencanaBezettingResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\RencanaBezettingResource;

class ListRencanaBezetting extends ListRecords
{
    protected static string $resource = RencanaBezettingResource::class;

    protected static ?string $title = 'History Bezetting';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
