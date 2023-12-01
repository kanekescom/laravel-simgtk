<?php

namespace Kanekescom\Simgtk\Filament\Resources\JenjangSekolahResource\Pages;

use Kanekescom\Simgtk\Filament\Resources\JenjangSekolahResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJenjangSekolah extends CreateRecord
{
    protected static string $resource = JenjangSekolahResource::class;

    protected static ?string $title = 'Create Jenjang Sekolah';
}
