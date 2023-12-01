<?php

namespace Kanekescom\Simgtk\Filament\Resources\MataPelajaranResource\Pages;

use Kanekescom\Simgtk\Filament\Resources\MataPelajaranResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMataPelajaran extends CreateRecord
{
    protected static string $resource = MataPelajaranResource::class;

    protected static ?string $title = 'Create Mata Pelajaran';
}
