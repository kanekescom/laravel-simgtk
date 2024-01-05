<?php

namespace Kanekescom\Simgtk\Filament\Resources\ImporResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Kanekescom\Simgtk\Filament\Resources\ImporResource;

class CreateImpor extends CreateRecord
{
    protected static string $resource = ImporResource::class;

    protected static ?string $title = 'Create Impor';
}
