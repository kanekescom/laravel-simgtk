<?php

namespace Kanekescom\Simgtk\Filament\Resources\RencanaBezzetingResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Kanekescom\Simgtk\Filament\Resources\RencanaBezzetingResource;

class EditRencanaBezzeting extends EditRecord
{
    protected static string $resource = RencanaBezzetingResource::class;

    protected static ?string $title = 'Edit Rencana Bezzeting';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
