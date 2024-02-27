<?php

namespace Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Kanekescom\Simgtk\Filament\Resources\PegawaiResource;

class EditPegawai extends EditRecord
{
    protected static string $resource = PegawaiResource::class;

    protected static ?string $title = 'Edit Pegawai';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
