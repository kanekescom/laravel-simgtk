<?php

namespace Kanekescom\Simgtk\Filament\Resources\SekolahResource\Pages;

use Kanekescom\Simgtk\Filament\Resources\SekolahResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSekolah extends EditRecord
{
    protected static string $resource = SekolahResource::class;

    protected static ?string $title = 'Edit Sekolah';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
