<?php

namespace Kanekescom\Simgtk\Filament\Resources\LiveBezettingResource\Pages;

use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\LiveBezettingResource;
use Kanekescom\Simgtk\Models\JenjangSekolah;

class ListLiveBezetting extends ListRecords
{
    protected static string $resource = LiveBezettingResource::class;

    protected static ?string $title = 'Live Bezetting';

    protected function getHeaderActions(): array
    {
        return [];
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
