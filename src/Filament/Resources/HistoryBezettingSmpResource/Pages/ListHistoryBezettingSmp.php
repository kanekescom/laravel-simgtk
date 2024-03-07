<?php

namespace Kanekescom\Simgtk\Filament\Resources\HistoryBezettingSmpResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Kanekescom\Simgtk\Filament\Resources\HistoryBezettingSmpResource;
use Kanekescom\Simgtk\Filament\Resources\LiveBezettingSmpResource;
use Kanekescom\Simgtk\Models\RencanaBezetting;

class ListHistoryBezettingSmp extends ListRecords
{
    protected static string $resource = HistoryBezettingSmpResource::class;

    protected static ?string $title = 'History Bezetting SMP';

    public function getSubheading(): string|Htmlable|null
    {
        return RencanaBezetting::aktif()->first()?->nama;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('live')
                ->label('Live')
                ->url(LiveBezettingSmpResource::getSlug())
                ->visible(auth()->user()->can('view_any_'.LiveBezettingSmpResource::class)),
        ];
    }
}
