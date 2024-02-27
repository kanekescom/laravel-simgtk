<?php

namespace Kanekescom\Simgtk\Filament\Resources\RancanganBezettingResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Kanekescom\Simgtk\Filament\Resources\LiveBezettingResource;
use Kanekescom\Simgtk\Filament\Resources\RancanganBezettingResource;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\RencanaBezetting;

class ListRancanganBezetting extends ListRecords
{
    protected static string $resource = RancanganBezettingResource::class;

    protected static ?string $title = 'Bezetting';

    public function getSubheading(): string|Htmlable|null
    {
        return RencanaBezetting::aktif()->first()?->nama;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('live-bezetting')
                ->label('Live')
                ->url(LiveBezettingResource::getSlug()),
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
                        ->aktif()
                        ->where('jenjang_sekolah_id', $jenjangSekolah->id)
                        ->defaultOrder()
                        ->count()
                )
                ->modifyQueryUsing(function ($query) use ($jenjangSekolah) {
                    return $query
                        ->aktif()
                        ->where('jenjang_sekolah_id', $jenjangSekolah->id)
                        ->defaultOrder();
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
