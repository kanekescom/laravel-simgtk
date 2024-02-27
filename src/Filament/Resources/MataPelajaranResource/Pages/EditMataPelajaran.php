<?php

namespace Kanekescom\Simgtk\Filament\Resources\MataPelajaranResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Kanekescom\Simgtk\Filament\Resources\MataPelajaranResource;

class EditMataPelajaran extends EditRecord
{
    protected static string $resource = MataPelajaranResource::class;

    protected static ?string $title = 'Edit Mata Pelajaran';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
