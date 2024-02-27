<?php

namespace Kanekescom\Simgtk\Filament\Resources\MataPelajaranResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Kanekescom\Simgtk\Filament\Resources\MataPelajaranResource;

class CreateMataPelajaran extends CreateRecord
{
    protected static string $resource = MataPelajaranResource::class;

    protected static ?string $title = 'Create Mata Pelajaran';
}
