<?php

namespace Kanekescom\Simgtk\Filament\Resources\MutasiResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Kanekescom\Simgtk\Filament\Resources\MutasiResource;

class EditMutasi extends EditRecord
{
    protected static string $resource = MutasiResource::class;

    protected static ?string $title = 'Edit Mutasi';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
