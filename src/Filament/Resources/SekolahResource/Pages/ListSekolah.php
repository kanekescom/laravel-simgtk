<?php

namespace Kanekescom\Simgtk\Filament\Resources\SekolahResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\SekolahResource;
use Kanekescom\Simgtk\Models\JenjangSekolah;

class ListSekolah extends ListRecords
{
    protected static string $resource = SekolahResource::class;

    protected static ?string $title = 'Sekolah';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create'),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];
        $tabs[''] = Tab::make('All')
            ->badge(
                $this->getModel()::query()
                    ->count()
            );

        $jenjangSekolahs = JenjangSekolah::all();

        foreach ($jenjangSekolahs as $jenjangSekolah) {
            $tabs[$jenjangSekolah->kode] = Tab::make($jenjangSekolah->id)
                ->badge(
                    $this->getModel()::query()
                        ->where('jenjang_sekolah_id', $jenjangSekolah->id)
                        ->defaultOrder()
                        ->count()
                )
                ->modifyQueryUsing(function ($query) use ($jenjangSekolah) {
                    return $query
                        ->where('jenjang_sekolah_id', $jenjangSekolah->id)
                        ->defaultOrder();
                })
                ->label($jenjangSekolah->nama);
        }

        return $tabs;
    }
}
