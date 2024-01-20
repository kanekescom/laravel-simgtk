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
        $tabs = ['all' => Tab::make('All')->badge($this->getModel()::count())];

        $jenjangSekolahs = JenjangSekolah::all();

        foreach ($jenjangSekolahs as $jenjangSekolah) {
            $tabs[$jenjangSekolah->id] = Tab::make($jenjangSekolah->id)
                ->badge($this->getModel()::where('jenjang_sekolah_id', $jenjangSekolah->id)->count())
                ->modifyQueryUsing(function ($query) use ($jenjangSekolah) {
                    return $query->where('jenjang_sekolah_id', $jenjangSekolah->id);
                })
                ->label($jenjangSekolah->nama);
        }

        return $tabs;
    }
}
