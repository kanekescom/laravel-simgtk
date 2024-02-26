<?php

namespace Kanekescom\Simgtk\Filament\Resources\PensiunPppkResource\Pages;

use Filament\Resources\Components\Tab;
use Kanekescom\Simgtk\Filament\Resources\PensiunPppkResource;
use Kanekescom\Simgtk\Filament\Resources\PensiunResource\Pages\ListPensiun;

class ListPensiunPppk extends ListPensiun
{
    protected static string $resource = PensiunPppkResource::class;

    protected static ?string $title = 'Pensiun PPPK';

    public function getTabs(): array
    {
        $tabs = [];
        $tabs['pensiun'] = Tab::make('pensiun')
            ->modifyQueryUsing(function ($query) {
                return $query->pensiun()->statusKepegawaianPppk();
            })
            ->badge($this->getModel()::query()->pensiun()->statusKepegawaianPppk()->count())
            ->label('Pensiun');
        $tabs['masuk-pensiun'] = Tab::make('masuk-pensiun')
            ->modifyQueryUsing(function ($query) {
                return $query->masukPensiun()->statusKepegawaianPppk();
            })
            ->badge($this->getModel()::query()->masukPensiun()->statusKepegawaianPppk()->count())
            ->label('Masuk Pensiun');

        $years = $this->getAddYearToListFromCurrentTo(5);

        foreach ($years as $year) {
            $tabs[$year] = Tab::make($year)
                ->modifyQueryUsing(function ($query) use ($year) {
                    return $query->pensiunTahun($year)->statusKepegawaianPppk();
                })
                ->badge($this->getModel()::query()->pensiunTahun($year)->statusKepegawaianPppk()->count())
                ->label($year);
        }

        return $tabs;
    }
}
