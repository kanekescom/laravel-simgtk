<?php

namespace Kanekescom\Simgtk\Filament\Resources\BidangStudiSertifikasiResource\Pages;

use Kanekescom\Simgtk\Filament\Resources\BidangStudiSertifikasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBidangStudiSertifikasi extends EditRecord
{
    protected static string $resource = BidangStudiSertifikasiResource::class;

    protected static ?string $title = 'Edit Bidang Studi Sertifikasi';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
