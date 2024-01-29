<?php

namespace Kanekescom\Simgtk\Filament\Resources\RancanganBezzetingResource\Pages;

use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\RancanganBezzetingResource;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListRancanganBezzeting extends ListRecords
{
    protected static string $resource = RancanganBezzetingResource::class;

    protected static ?string $title = 'Bezzeting';

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->fields([
                    ImportField::make('id')
                        ->rules('required|max:255')
                        ->label('ID'),
                    ImportField::make('rencana.nama')
                        ->rules('required|max:255')
                        ->label('Nama'),
                    ImportField::make('sekolah.nama')
                        ->rules('required|max:255')
                        ->label('Sekolah'),
                    ImportField::make('jenjangSekolah.nama')
                        ->rules('required|max:255')
                        ->label('Jenjang Sekolah'),
                    ImportField::make('wilayah.nama')
                        ->rules('required|max:255')
                        ->label('Wilayah'),
                    ImportField::make('jumlah_kelas')
                        ->rules('required|max:255')
                        ->label('Jumlah Kelas'),
                    ImportField::make('jumlah_rombel')
                        ->rules('required|max:255')
                        ->label('Jumlah Rombel'),
                    ImportField::make('jumlah_siswa')
                        ->rules('required|max:255')
                        ->label('Jumlah Siswa'),
                ]),
            ExportAction::make()
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename(fn ($resource) => $resource::getSlug() . '-' . now()->format('Y-m-d'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                        ->withColumns([
                            Column::make('id')->heading('ID'),
                            Column::make('rencana.nama')->heading('Nama'),
                            Column::make('rencana.tanggal_mulai')->heading('Tanggal Mulai'),
                            Column::make('rencana.tanggal_berakhir')->heading('Tanggal Berakhir'),
                            Column::make('wilayah.nama')->heading('Wilayah'),
                            Column::make('jenjangSekolah.nama')->heading('Jenjang'),
                            Column::make('wilayah.nama')->heading('Wilayah'),
                            Column::make('jumlah_kelas')->heading('Jumlah Kelas'),
                            Column::make('jumlah_rombel')->heading('Jumlah Rombel'),
                            Column::make('jumlah_siswa')->heading('Jumlah Siswa'),
                        ])
                        ->ignoreFormatting(),
                ])->icon(false),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];

        $jenjangSekolahs = JenjangSekolah::all();

        foreach ($jenjangSekolahs as $jenjangSekolah) {
            $tabs[$jenjangSekolah->kode] = Tab::make($jenjangSekolah->id)
                ->badge(
                    $this->getModel()::query()
                        ->aktif()
                        ->defaultOrder()
                        ->where('jenjang_sekolah_id', $jenjangSekolah->id)
                        ->count()
                )
                ->modifyQueryUsing(function ($query) use ($jenjangSekolah) {
                    return $query
                        ->aktif()
                        ->defaultOrder()
                        ->where('jenjang_sekolah_id', $jenjangSekolah->id);
                })
                ->label($jenjangSekolah->nama);
        }

        return $tabs;
    }
}
