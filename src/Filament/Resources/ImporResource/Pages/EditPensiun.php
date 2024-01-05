<?php

namespace Kanekescom\Simgtk\Filament\Resources\ImporResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Kanekescom\Simgtk\Filament\Resources\ImporResource;

class EditImpor extends EditRecord
{
    protected static string $resource = ImporResource::class;

    protected static ?string $title = 'Edit Impor';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
