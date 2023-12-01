<?php

namespace Kanekescom\Simgtk\Filament\Resources\BidangStudiPendidikanResource\Pages;

use Kanekescom\Simgtk\Filament\Resources\BidangStudiPendidikanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBidangStudiPendidikan extends EditRecord
{
    protected static string $resource = BidangStudiPendidikanResource::class;

    protected static ?string $title = 'Edit Bidang Studi Pendidikan';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
