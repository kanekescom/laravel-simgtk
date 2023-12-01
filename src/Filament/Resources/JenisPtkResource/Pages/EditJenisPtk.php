<?php

namespace Kanekescom\Simgtk\Filament\Resources\JenisPtkResource\Pages;

use Kanekescom\Simgtk\Filament\Resources\JenisPtkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJenisPtk extends EditRecord
{
    protected static string $resource = JenisPtkResource::class;

    protected static ?string $title = 'Edit Jenis PTK';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
