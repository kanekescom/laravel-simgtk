<?php

namespace Kanekescom\Simgtk\Filament\Resources\WilayahResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\WilayahResource;

class ListWilayah extends ListRecords
{
    protected static string $resource = WilayahResource::class;

    protected static ?string $title = 'Wilayah';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
