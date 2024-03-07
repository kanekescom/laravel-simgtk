<?php

namespace Kanekescom\Simgtk\Filament\Resources\LiveBezettingSdResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\HistoryBezettingSdResource;
use Kanekescom\Simgtk\Filament\Resources\LiveBezettingSdResource;

class ListLiveBezettingSd extends ListRecords
{
    protected static string $resource = LiveBezettingSdResource::class;

    protected static ?string $title = 'Live Bezetting SD';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('history')
                ->label('History')
                ->url(HistoryBezettingSdResource::getSlug())
                ->visible(auth()->user()->can('view_any_'.HistoryBezettingSdResource::class)),
        ];
    }
}
