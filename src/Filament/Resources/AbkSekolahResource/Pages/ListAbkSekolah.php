<?php

namespace Kanekescom\Simgtk\Filament\Resources\AbkSekolahResource\Pages;

use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\AbkSekolahResource;
use Kanekescom\Simgtk\Models\JenjangSekolah;

class ListAbkSekolah extends ListRecords
{
    protected static string $resource = AbkSekolahResource::class;

    protected static ?string $title = 'ABK Sekolah';

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
