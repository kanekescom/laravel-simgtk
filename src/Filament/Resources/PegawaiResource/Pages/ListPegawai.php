<?php

namespace Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Pages;

use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Enums\StatusKepegawaianEnum;
use Kanekescom\Simgtk\Filament\Resources\PegawaiResource;
use Kanekescom\Simgtk\Imports\PegawaiDapodikImport;
use Spatie\LaravelOptions\Options;

class ListPegawai extends ListRecords
{
    protected static string $resource = PegawaiResource::class;

    protected static ?string $title = 'Pegawai';

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->use(PegawaiDapodikImport::class)
                ->slideOver()
                ->icon(false)
                ->label('Import')
                ->visible(auth()->user()->can('import_'.self::$resource)),
            Actions\CreateAction::make()->label('Create'),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];

        $tabs[''] = Tab::make('All')
            ->badge(
                $this->getModel()::query()
                    ->aktif()
                    ->count()
            );

        $statusKepegawaians = Options::forEnum(StatusKepegawaianEnum::class)->toArray();

        foreach ($statusKepegawaians as $statusKepegawaian) {
            $tabs[$statusKepegawaian['value']] = Tab::make($statusKepegawaian['value'])
                ->badge(
                    $this->getModel()::query()
                        ->aktif()
                        ->where('status_kepegawaian_kode', $statusKepegawaian['value'])
                        ->count()
                )
                ->modifyQueryUsing(function ($query) use ($statusKepegawaian) {
                    return $query
                        ->aktif()
                        ->where('status_kepegawaian_kode', $statusKepegawaian['value']);
                })
                ->label($statusKepegawaian['label']);
        }

        return $tabs;
    }
}
