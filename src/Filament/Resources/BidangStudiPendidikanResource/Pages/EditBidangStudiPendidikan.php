<?php

namespace Kanekescom\Simgtk\Filament\Resources\BidangStudiPendidikanResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Kanekescom\Simgtk\Filament\Resources\BidangStudiPendidikanResource;

class EditBidangStudiPendidikan extends EditRecord
{
    protected static string $resource = BidangStudiPendidikanResource::class;

    protected static ?string $title = 'Edit Bidang Studi Pendidikan';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
