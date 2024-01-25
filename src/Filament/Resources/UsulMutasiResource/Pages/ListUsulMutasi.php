<?php

namespace Kanekescom\Simgtk\Filament\Resources\UsulMutasiResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\UsulMutasiResource;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListUsulMutasi extends ListRecords
{
    protected static string $resource = UsulMutasiResource::class;

    protected static ?string $title = 'Usul Mutasi';

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
                            Column::make('rencana.nama')->heading('Rencana'),
                            Column::make('pegawai.nama_gelar')->heading('Nama'),
                            Column::make('pegawai.nik')->heading('NIK'),
                            Column::make('pegawai.nuptk')->heading('NUPTK'),
                            Column::make('pegawai.nip')->heading('NIP'),
                            Column::make('asalSekolah.nama')->heading('Asal'),
                            Column::make('tujuanSekolah.nama')->heading('Tujuan'),
                        ])
                        ->ignoreFormatting(),
                ]),
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
