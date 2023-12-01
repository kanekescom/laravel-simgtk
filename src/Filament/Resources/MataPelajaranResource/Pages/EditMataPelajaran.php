<?php

namespace Kanekescom\Simgtk\Filament\Resources\MataPelajaranResource\Pages;

use Kanekescom\Simgtk\Filament\Resources\MataPelajaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMataPelajaran extends EditRecord
{
    protected static string $resource = MataPelajaranResource::class;

    protected static ?string $title = 'Edit Mata Pelajaran';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
