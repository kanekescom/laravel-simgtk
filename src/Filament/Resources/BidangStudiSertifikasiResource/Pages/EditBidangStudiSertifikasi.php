<?php

namespace Kanekescom\Simgtk\Filament\Resources\BidangStudiSertifikasiResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Kanekescom\Simgtk\Filament\Resources\BidangStudiSertifikasiResource;

class EditBidangStudiSertifikasi extends EditRecord
{
    protected static string $resource = BidangStudiSertifikasiResource::class;

    protected static ?string $title = 'Edit Bidang Studi Sertifikasi';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
