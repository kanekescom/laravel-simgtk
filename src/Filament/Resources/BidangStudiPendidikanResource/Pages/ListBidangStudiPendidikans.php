<?php

namespace Kanekescom\Simgtk\Filament\Resources\BidangStudiPendidikanResource\Pages;

use Kanekescom\Simgtk\Filament\Resources\BidangStudiPendidikanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

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
