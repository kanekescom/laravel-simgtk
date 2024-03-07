<?php

namespace Kanekescom\Simgtk\Filament\Resources\JenjangPendidikanResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Kanekescom\Simgtk\Filament\Resources\JenjangPendidikanResource;

class CreateJenjangPendidikan extends CreateRecord
{
    protected static string $resource = JenjangPendidikanResource::class;

    protected static ?string $title = 'Create Jenjang Pendidikan';
}
