<?php

namespace Kanekescom\Simgtk\Filament\Resources\JenisPtkResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\JenisPtkResource;

class ListJenisPtk extends ListRecords
{
    protected static string $resource = JenisPtkResource::class;

    protected static ?string $title = 'Jenis PTK';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make()->label('Create'),
        ];
    }
}
