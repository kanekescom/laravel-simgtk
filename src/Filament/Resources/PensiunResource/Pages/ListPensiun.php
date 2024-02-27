<?php

namespace Kanekescom\Simgtk\Filament\Resources\PensiunResource\Pages;

use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\PensiunResource;

class ListPensiun extends ListRecords
{
    protected static string $resource = PensiunResource::class;

    protected static ?string $title = 'Pensiun';

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        $tabs = [];
        $tabs['pensiun'] = Tab::make('pensiun')
            ->modifyQueryUsing(function ($query) {
                return $query->pensiun();
            })
            ->badge($this->getModel()::query()->pensiun()->count())
            ->label('Pensiun');
        $tabs['masuk-pensiun'] = Tab::make('masuk-pensiun')
            ->modifyQueryUsing(function ($query) {
                return $query->masukPensiun();
            })
            ->badge($this->getModel()::query()->masukPensiun()->count())
            ->label('Masuk Pensiun');

        $years = $this->getAddYearToListFromCurrentTo(5);

        foreach ($years as $year) {
            $tabs[$year] = Tab::make($year)
                ->modifyQueryUsing(function ($query) use ($year) {
                    return $query->pensiunTahun($year);
                })
                ->badge($this->getModel()::query()->pensiunTahun($year)->count())
                ->label($year);
        }

        return $tabs;
    }

    public function getAddYearToListFromCurrentTo($addYear): array
    {
        $currentYear = now()->year;

        for ($i = 0; $i <= $addYear; $i++) {
            $years[] = $currentYear + $i;
        }

        return $years ?? [];
    }
}
