<?php

namespace Kanekescom\Simgtk\Filament\Resources\MutasiResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\MutasiResource;

class ListMutasi extends ListRecords
{
    protected static string $resource = MutasiResource::class;

    protected static ?string $title = 'Mutasi';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
