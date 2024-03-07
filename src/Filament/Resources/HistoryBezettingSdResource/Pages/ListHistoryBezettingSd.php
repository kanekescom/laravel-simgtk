<?php

namespace Kanekescom\Simgtk\Filament\Resources\HistoryBezettingSdResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Kanekescom\Simgtk\Filament\Resources\HistoryBezettingSdResource;
use Kanekescom\Simgtk\Filament\Resources\LiveBezettingSdResource;
use Kanekescom\Simgtk\Models\RencanaBezetting;

class ListHistoryBezettingSd extends ListRecords
{
    protected static string $resource = HistoryBezettingSdResource::class;

    protected static ?string $title = 'History Bezetting SD';

    public function getSubheading(): string|Htmlable|null
    {
        return RencanaBezetting::aktif()->first()?->nama;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('live')
                ->label('Live')
                ->url(LiveBezettingSdResource::getSlug())
                ->visible(auth()->user()->can('view_any_'.LiveBezettingSdResource::class)),
        ];
    }
}
