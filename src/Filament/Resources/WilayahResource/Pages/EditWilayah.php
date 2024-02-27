<?php

namespace Kanekescom\Simgtk\Filament\Resources\WilayahResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Kanekescom\Simgtk\Filament\Resources\WilayahResource;

class EditWilayah extends EditRecord
{
    protected static string $resource = WilayahResource::class;

    protected static ?string $title = 'Edit Wilayah';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
