<?php

namespace Kanekescom\Simgtk\Filament\Resources\BezzetingResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Kanekescom\Simgtk\Filament\Resources\BezzetingResource;

class CreateBezzeting extends CreateRecord
{
    protected static string $resource = BezzetingResource::class;

    protected static ?string $title = 'Create Bezzeting';
}
