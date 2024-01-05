<?php

namespace Kanekescom\Simgtk\Filament\Resources\PensiunResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Kanekescom\Simgtk\Filament\Resources\PensiunResource;

class CreatePensiun extends CreateRecord
{
    protected static string $resource = PensiunResource::class;

    protected static ?string $title = 'Create Pensiun';
}
