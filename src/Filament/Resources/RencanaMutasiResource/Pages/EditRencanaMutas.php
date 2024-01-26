<?php

namespace Kanekescom\Simgtk\Filament\Resources\RencanaMutasiResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Kanekescom\Simgtk\Filament\Resources\RencanaMutasiResource;

class EditRencanaMutasi extends EditRecord
{
    protected static string $resource = RencanaMutasiResource::class;

    protected static ?string $title = 'Edit Rencana Mutasi';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
