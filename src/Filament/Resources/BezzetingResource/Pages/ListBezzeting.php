<?php

namespace Kanekescom\Simgtk\Filament\Resources\BezzetingResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\BezzetingResource;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListBezzeting extends ListRecords
{
    protected static string $resource = BezzetingResource::class;

    protected static ?string $title = 'Bezzeting';

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename(fn ($resource) => $resource::getSlug().'-'.now()->format('Y-m-d'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                        ->withColumns([
                            Column::make('wilayah.nama')->heading('Wilayah'),
                            Column::make('jenjangSekolah.nama')->heading('Jenjang'),
                            Column::make('nama')->heading('Nama'),
                            Column::make('jumlah_kelas')->heading('Jumlah Kelas'),
                            Column::make('jumlah_rombel')->heading('Jumlah Rombel'),
                            Column::make('jumlah_siswa')->heading('Jumlah Siswa'),
                        ])
                        ->ignoreFormatting(),
                ]),
            Actions\CreateAction::make()->label('Create'),
        ];
    }

    public function getTabs(): array
    {
        $tabs = ['all' => Tab::make('All')
            ->badge($this->getModel()::query()->defaultOrder()->count())
            ->modifyQueryUsing(function ($query) {
                return $query
                    ->defaultOrder();
            })];

        $jenjangSekolahs = JenjangSekolah::all();

        foreach ($jenjangSekolahs as $jenjangSekolah) {
            $tabs[$jenjangSekolah->id] = Tab::make($jenjangSekolah->id)
                ->badge($this->getModel()::query()
                    ->where('jenjang_sekolah_id', $jenjangSekolah->id)->count())
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
