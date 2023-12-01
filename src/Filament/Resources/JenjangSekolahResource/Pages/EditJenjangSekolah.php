<?php

namespace Kanekescom\Simgtk\Filament\Resources\JenjangSekolahResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Kanekescom\Simgtk\Filament\Resources\JenjangSekolahResource;

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
