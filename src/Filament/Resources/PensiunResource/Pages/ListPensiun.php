<?php

namespace Kanekescom\Simgtk\Filament\Resources\PensiunResource\Pages;

use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\PensiunResource;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

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
                ]),
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
}
