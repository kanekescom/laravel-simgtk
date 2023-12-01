<?php

namespace Kanekescom\Simgtk\Filament\Resources\JenjangSekolahResource\Pages;

use Kanekescom\Simgtk\Filament\Resources\JenjangSekolahResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJenjangSekolah extends EditRecord
{
    protected static string $resource = JenjangSekolahResource::class;

    protected static ?string $title = 'Edit Jenjang Sekolah';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
