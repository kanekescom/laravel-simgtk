<?php

namespace Kanekescom\Simgtk\Filament\Resources\LiveBezettingResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\HistoryBezettingSdResource;
use Kanekescom\Simgtk\Filament\Resources\HistoryBezettingSmpResource;
use Kanekescom\Simgtk\Filament\Resources\LiveBezettingResource;
use Kanekescom\Simgtk\Models\JenjangSekolah;

class ListLiveBezetting extends ListRecords
{
    protected static string $resource = LiveBezettingResource::class;

    protected static ?string $title = 'Live Bezetting';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('history-sd')
                ->label('History SD')
                ->url(HistoryBezettingSdResource::getSlug())
                ->visible(auth()->user()->can('view_any_'.HistoryBezettingSdResource::class)),
            Actions\Action::make('history-smp')
                ->label('History SMP')
                ->url(HistoryBezettingSmpResource::getSlug())
                ->visible(auth()->user()->can('view_any_'.HistoryBezettingSmpResource::class)),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];

        $jenjangSekolahs = JenjangSekolah::all();

        foreach ($jenjangSekolahs as $jenjangSekolah) {
            $tabs[$jenjangSekolah->kode] = Tab::make($jenjangSekolah->id)
                ->badge(
                    $this->getModel()::query()
                        ->where('jenjang_sekolah_id', $jenjangSekolah->id)
                        ->count()
                )
                ->modifyQueryUsing(function ($query) use ($jenjangSekolah) {
                    return $query
                        ->where('jenjang_sekolah_id', $jenjangSekolah->id);
                })
                ->label($jenjangSekolah->nama);
        }

        return $tabs;
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return JenjangSekolah::first()->kode;
    }
}
