<?php

namespace Kanekescom\Simgtk\Filament\Resources\MutasiResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\MutasiResource;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListMutasi extends ListRecords
{
    protected static string $resource = MutasiResource::class;

    protected static ?string $title = 'Mutasi';

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
                            Column::make('rancangan.nama')->heading('Rancangan'),
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
