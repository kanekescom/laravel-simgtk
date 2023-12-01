<?php

namespace Kanekescom\Simgtk\Filament\Resources\JenjangSekolahResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Kanekescom\Simgtk\Filament\Resources\JenjangSekolahResource;

class CreateJenjangSekolah extends CreateRecord
{
    protected static string $resource = JenjangSekolahResource::class;

    protected static ?string $title = 'Create Jenjang Sekolah';
}
