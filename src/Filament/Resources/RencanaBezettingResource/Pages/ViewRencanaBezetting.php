<?php

namespace Kanekescom\Simgtk\Filament\Resources\RencanaBezettingResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Kanekescom\Simgtk\Filament\Resources\RencanaBezettingResource;

class ViewRencanaBezetting extends ViewRecord
{
    protected static string $resource = RencanaBezettingResource::class;

    protected static ?string $title = 'View History Bezetting';

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
