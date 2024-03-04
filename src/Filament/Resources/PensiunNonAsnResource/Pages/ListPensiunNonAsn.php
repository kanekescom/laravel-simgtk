<?php

namespace Kanekescom\Simgtk\Filament\Resources\PensiunNonAsnResource\Pages;

use Filament\Resources\Components\Tab;
use Kanekescom\Simgtk\Filament\Resources\PensiunNonAsnResource;
use Kanekescom\Simgtk\Filament\Resources\PensiunResource\Pages\ListPensiun;

class ListPensiunNonAsn extends ListPensiun
{
    protected static string $resource = PensiunNonAsnResource::class;

    protected static ?string $title = 'Pensiun NonASN';

    public function getTabs(): array
    {
        $tabs = [];
        $tabs['pensiun'] = Tab::make('pensiun')
            ->modifyQueryUsing(function ($query) {
                return $query->pensiun()->statusKepegawaianNonAsn();
            })
            ->badge($this->getModel()::query()->pensiun()->statusKepegawaianNonAsn()->count())
            ->label('Pensiun');
        $tabs['masuk-pensiun'] = Tab::make('masuk-pensiun')
            ->modifyQueryUsing(function ($query) {
                return $query->masukPensiun()->statusKepegawaianNonAsn();
            })
            ->badge($this->getModel()::query()->masukPensiun()->statusKepegawaianNonAsn()->count())
            ->label('Masuk Pensiun');

        $years = $this->getAddYearToListFromCurrentTo(5);

        foreach ($years as $year) {
            $tabs[$year] = Tab::make($year)
                ->modifyQueryUsing(function ($query) use ($year) {
                    return $query->pensiunTahun($year)->statusKepegawaianNonAsn();
                })
                ->badge($this->getModel()::query()->pensiunTahun($year)->statusKepegawaianNonAsn()->count())
                ->label($year);
        }

        return $tabs;
    }
}
