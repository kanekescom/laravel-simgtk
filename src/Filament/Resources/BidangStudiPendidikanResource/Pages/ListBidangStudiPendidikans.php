<?php

namespace Kanekescom\Simgtk\Filament\Resources\BidangStudiPendidikanResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\BidangStudiPendidikanResource;

class ListBidangStudiPendidikans extends ListRecords
{
    protected static string $resource = BidangStudiPendidikanResource::class;

    protected static ?string $title = 'Bidang Studi Pendidikan';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
