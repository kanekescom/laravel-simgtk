<?php

namespace Kanekescom\Simgtk\Filament\Resources\JenisPtkResource\Pages;

use Kanekescom\Simgtk\Filament\Resources\JenisPtkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJenisPtks extends ListRecords
{
    protected static string $resource = JenisPtkResource::class;

    protected static ?string $title = 'Jenis PTK';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
