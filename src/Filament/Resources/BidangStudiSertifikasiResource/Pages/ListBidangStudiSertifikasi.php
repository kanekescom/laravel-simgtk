<?php

namespace Kanekescom\Simgtk\Filament\Resources\BidangStudiSertifikasiResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\BidangStudiSertifikasiResource;

class ListBidangStudiSertifikasi extends ListRecords
{
    protected static string $resource = BidangStudiSertifikasiResource::class;

    protected static ?string $title = 'Bidang Studi Sertifikasi';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make()->label('Create'),
        ];
    }
}
