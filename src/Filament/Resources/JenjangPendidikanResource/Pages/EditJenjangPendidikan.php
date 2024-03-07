<?php

namespace Kanekescom\Simgtk\Filament\Resources\JenjangPendidikanResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Kanekescom\Simgtk\Filament\Resources\JenjangPendidikanResource;

class EditJenjangPendidikan extends EditRecord
{
    protected static string $resource = JenjangPendidikanResource::class;

    protected static ?string $title = 'Edit Jenjang Pendidikan';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
