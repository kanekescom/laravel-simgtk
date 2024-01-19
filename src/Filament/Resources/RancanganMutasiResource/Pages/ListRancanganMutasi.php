<?php

namespace Kanekescom\Simgtk\Filament\Resources\RancanganMutasiResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\RancanganMutasiResource;

class ListRancanganMutasi extends ListRecords
{
    protected static string $resource = RancanganMutasiResource::class;

    protected static ?string $title = 'Rancangan Mutasi';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
