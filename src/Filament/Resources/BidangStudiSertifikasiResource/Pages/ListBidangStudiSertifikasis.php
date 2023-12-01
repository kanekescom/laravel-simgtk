<?php

namespace Kanekescom\Simgtk\Filament\Resources\BidangStudiSertifikasiResource\Pages;

use Kanekescom\Simgtk\Filament\Resources\BidangStudiSertifikasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBidangStudiSertifikasis extends ListRecords
{
    protected static string $resource = BidangStudiSertifikasiResource::class;

    protected static ?string $title = 'Bidang Studi Sertifikasi';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
