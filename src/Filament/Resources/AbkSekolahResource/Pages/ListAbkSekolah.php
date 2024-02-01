<?php

namespace Kanekescom\Simgtk\Filament\Resources\AbkSekolahResource\Pages;

use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\AbkSekolahResource;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListAbkSekolah extends ListRecords
{
    protected static string $resource = AbkSekolahResource::class;

    protected static ?string $title = 'ABK Sekolah';

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->uniqueField('id')
                ->fields([
                    ImportField::make('id')
                        ->rules('required|max:255')
                        ->label('ID'),
                    ImportField::make('nama')
                        ->rules('required|length:255')
                        ->label('Nama'),
                    ImportField::make('npsn')
                        ->rules('required|length:8')
                        ->label('NPSN'),
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
                        ->withFilename(fn ($resource) => str($resource::getSlug())->replace('/', '_') . '-' . now()->format('Y-m-d'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                        ->withColumns([
                            Column::make('id')->heading('ID'),
                            Column::make('nama')->heading('Nama'),
                            Column::make('npsn')->heading('NPSN'),
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

        $tabs[''] = Tab::make('All')
            ->badge(
                $this->getModel()::query()
                    ->count()
            );

        $jenjangSekolahs = JenjangSekolah::all();

        foreach ($jenjangSekolahs as $jenjangSekolah) {
            $tabs[$jenjangSekolah->kode] = Tab::make($jenjangSekolah->id)
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
