<?php

namespace Kanekescom\Simgtk\Filament\Resources\JenjangPendidikanResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\JenjangPendidikanResource;

class ListJenjangPendidikan extends ListRecords
{
    protected static string $resource = JenjangPendidikanResource::class;

    protected static ?string $title = 'Jenjang Pendidikan';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
