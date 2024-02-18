<?php

namespace Kanekescom\Simgtk\Filament\Resources\LiveBezettingSmpResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\HistoryBezettingSmpResource;
use Kanekescom\Simgtk\Filament\Resources\LiveBezettingSmpResource;

class ListLiveBezettingSmp extends ListRecords
{
    protected static string $resource = LiveBezettingSmpResource::class;

    protected static ?string $title = 'Live Bezetting SMP';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('history')
                ->label('History')
                ->url(HistoryBezettingSmpResource::getSlug()),
        ];
    }
}
