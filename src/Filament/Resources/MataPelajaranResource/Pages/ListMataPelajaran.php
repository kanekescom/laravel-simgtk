<?php

namespace Kanekescom\Simgtk\Filament\Resources\MataPelajaranResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\MataPelajaranResource;
use Kanekescom\Simgtk\Models\JenjangSekolah;

class ListMataPelajaran extends ListRecords
{
    protected static string $resource = MataPelajaranResource::class;

    protected static ?string $title = 'Mata Pelajaran';

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
            $tabs[$jenjangSekolah->id] = Tab::make($jenjangSekolah->id)
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
}
