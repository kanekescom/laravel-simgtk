<?php

namespace Kanekescom\Simgtk\Filament\Resources\JenisPtkResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Kanekescom\Simgtk\Filament\Resources\JenisPtkResource;

class EditJenisPtk extends EditRecord
{
    protected static string $resource = JenisPtkResource::class;

    protected static ?string $title = 'Edit Jenis PTK';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
