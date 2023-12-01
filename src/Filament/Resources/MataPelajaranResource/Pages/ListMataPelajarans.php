<?php

namespace Kanekescom\Simgtk\Filament\Resources\MataPelajaranResource\Pages;

use Kanekescom\Simgtk\Filament\Resources\MataPelajaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMataPelajarans extends ListRecords
{
    protected static string $resource = MataPelajaranResource::class;

    protected static ?string $title = 'Mata Pelajaran';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
