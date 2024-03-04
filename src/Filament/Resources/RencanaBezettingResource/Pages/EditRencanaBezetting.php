<?php

namespace Kanekescom\Simgtk\Filament\Resources\RencanaBezettingResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Kanekescom\Simgtk\Filament\Resources\RencanaBezettingResource;

class EditRencanaBezetting extends EditRecord
{
    protected static string $resource = RencanaBezettingResource::class;

    protected static ?string $title = 'Edit History Bezetting';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
