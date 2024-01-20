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
        return [
            //
        ];
    }

    public function getTabs(): array
    {
        return [
            'pensiun' => Tab::make('pensiun')
                ->modifyQueryUsing(function ($query) {
                    return $query
                        ->pensiun();
                })
                ->badge($this->getModel()::query()->pensiun()->count())
                ->label('Pensiun'),
            'akan-pensiun' => Tab::make('akan-pensiun')
                ->modifyQueryUsing(function ($query) {
                    return $query
                        ->akanPensiun();
                })
                ->badge($this->getModel()::query()->akanPensiun()->count())
                ->label('Akan Pensiun'),
        ];
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'pensiun';
    }
}
