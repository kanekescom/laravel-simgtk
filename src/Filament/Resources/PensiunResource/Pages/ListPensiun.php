<?php

namespace Kanekescom\Simgtk\Filament\Resources\PensiunResource\Pages;

use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\PensiunResource;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListPensiun extends ListRecords
{
    protected static string $resource = PensiunResource::class;

    protected static ?string $title = 'Pensiun';

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename(fn ($resource) => $resource::getSlug() . '-' . now()->format('Y-m-d'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                        ->withColumns([
                            Column::make('nama_gelar')->heading('Nama'),
                            Column::make('nik')->heading('NIK'),
                            Column::make('nuptk')->heading('NUPTK'),
                            Column::make('nip')->heading('NIP'),
                            Column::make('status_kepegawaian_kode')->heading('Status'),
                            Column::make('golongan_kode')->heading('Golongan'),
                            Column::make('mataPelajaran.nama')->heading('Mata Pelajaran'),
                            Column::make('sekolah.nama')->heading('Sekolah'),
                            Column::make('tmt_pensiun')->heading('TMT'),
                            Column::make('nomor_sk_pensiun')->heading('Nomor SK'),
                            Column::make('tanggal_sk_pensiun')->heading('Tanggal SK'),
                            Column::make('is_kepsek')->heading('Kepsek'),
                        ])
                        ->ignoreFormatting(),
                ])->icon(false),
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
            'masuk-pensiun' => Tab::make('masuk-pensiun')
                ->modifyQueryUsing(function ($query) {
                    return $query
                        ->masukPensiun();
                })
                ->badge($this->getModel()::query()->masukPensiun()->count())
                ->label('Masuk Pensiun'),
            'pensiun-tahun-ini' => Tab::make('pensiun-tahun-ini')
                ->modifyQueryUsing(function ($query) {
                    return $query
                        ->pensiunTahunIni();
                })
                ->badge($this->getModel()::query()->pensiunTahunIni()->count())
                ->label('Tahun Ini'),
            'pensiun-tahun-depan' => Tab::make('pensiun-tahun-depan')
                ->modifyQueryUsing(function ($query) {
                    return $query
                        ->pensiunTahunDepan();
                })
                ->badge($this->getModel()::query()->pensiunTahunDepan()->count())
                ->label('Tahun Depan'),
        ];
    }
}
