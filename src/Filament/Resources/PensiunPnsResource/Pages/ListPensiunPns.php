<?php

namespace Kanekescom\Simgtk\Filament\Resources\PensiunPnsResource\Pages;

use Filament\Resources\Components\Tab;
use Kanekescom\Simgtk\Filament\Resources\PensiunPnsResource;
use Kanekescom\Simgtk\Filament\Resources\PensiunResource\Pages\ListPensiun;

class ListPensiunPns extends ListPensiun
{
    protected static string $resource = PensiunPnsResource::class;

    protected static ?string $title = 'Pensiun PNS';

    public function getTabs(): array
    {
        $tabs = [];
        $tabs['pensiun'] = Tab::make('pensiun')
            ->modifyQueryUsing(function ($query) {
                return $query->pensiun()->statusKepegawaianPns();
            })
            ->badge($this->getModel()::query()->pensiun()->statusKepegawaianPns()->count())
            ->label('Pensiun');
        $tabs['masuk-pensiun'] = Tab::make('masuk-pensiun')
            ->modifyQueryUsing(function ($query) {
                return $query->masukPensiun()->statusKepegawaianPns();
            })
            ->badge($this->getModel()::query()->masukPensiun()->statusKepegawaianPns()->count())
            ->label('Masuk Pensiun');

        $years = $this->getAddYearToListFromCurrentTo(5);

        foreach ($years as $year) {
            $tabs[$year] = Tab::make($year)
                ->modifyQueryUsing(function ($query) use ($year) {
                    return $query->pensiunTahun($year)->statusKepegawaianPns();
                })
                ->badge($this->getModel()::query()->pensiunTahun($year)->statusKepegawaianPns()->count())
                ->label($year);
        }

        return $tabs;
    }
}
