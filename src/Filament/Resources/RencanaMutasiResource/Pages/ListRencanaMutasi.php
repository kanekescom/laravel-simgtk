<?php

namespace Kanekescom\Simgtk\Filament\Resources\RencanaMutasiResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\RencanaMutasiResource;

class ListRencanaMutasi extends ListRecords
{
    protected static string $resource = RencanaMutasiResource::class;

    protected static ?string $title = 'Rencana Mutasi';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
