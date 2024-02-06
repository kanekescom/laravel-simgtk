<?php

namespace Kanekescom\Simgtk\Filament\Resources\PensiunResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Kanekescom\Simgtk\Filament\Resources\PensiunResource;

class EditPensiun extends EditRecord
{
    protected static string $resource = PensiunResource::class;

    protected static ?string $title = 'Edit Pensiun';

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
