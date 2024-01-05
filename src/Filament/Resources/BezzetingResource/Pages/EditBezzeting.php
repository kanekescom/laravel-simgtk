<?php

namespace Kanekescom\Simgtk\Filament\Resources\BezzetingResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Kanekescom\Simgtk\Filament\Resources\BezzetingResource;

class EditBezzeting extends EditRecord
{
    protected static string $resource = BezzetingResource::class;

    protected static ?string $title = 'Edit Bezzeting';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
