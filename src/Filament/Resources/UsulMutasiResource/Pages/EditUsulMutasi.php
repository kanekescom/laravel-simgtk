<?php

namespace Kanekescom\Simgtk\Filament\Resources\UsulMutasiResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Kanekescom\Simgtk\Filament\Resources\UsulMutasiResource;

class EditUsulMutasi extends EditRecord
{
    protected static string $resource = UsulMutasiResource::class;

    protected static ?string $title = 'Edit Usul Mutasi';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
