<?php

namespace Kanekescom\Simgtk\Filament\Resources\RancanganMutasiResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Kanekescom\Simgtk\Filament\Resources\RancanganMutasiResource;

class EditRancanganMutasi extends EditRecord
{
    protected static string $resource = RancanganMutasiResource::class;

    protected static ?string $title = 'Edit Rancangan Mutasi';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
