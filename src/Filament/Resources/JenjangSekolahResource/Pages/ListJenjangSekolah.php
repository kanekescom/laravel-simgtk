<?php

namespace Kanekescom\Simgtk\Filament\Resources\JenjangSekolahResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\JenjangSekolahResource;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListJenjangSekolah extends ListRecords
{
    protected static string $resource = JenjangSekolahResource::class;

    protected static ?string $title = 'Jenjang Sekolah';

    protected function getHeaderActions(): array
    {
        return [
            // ImportAction::make()
            //     ->fields([
            //         ImportField::make('id')
            //             ->rules('required|max:255')
            //             ->label('ID'),
            //         ImportField::make('kode')
            //             ->rules('required|max:255')
            //             ->label('Kode'),
            //         ImportField::make('nama')
            //             ->rules('required|max:255')
            //             ->label('Nama'),
            //     ]),
            // ExportAction::make()
            //     ->exports([
            //         ExcelExport::make()
            //             ->withFilename(fn ($resource) => str($resource::getSlug())->replace('/', '_') . '-' . now()->format('Y-m-d'))
            //             ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
            //             ->withColumns([
            //                 Column::make('id')->heading('ID'),
            //                 Column::make('kode')->heading('Kode'),
            //                 Column::make('nama')->heading('Nama'),
            //                 Column::make('sekolah_count')->getStateUsing(fn ($record) => $record->sekolah()->count())->heading('Jumlah Sekolah'),
            //                 Column::make('pegawai_aktif_count')->getStateUsing(fn ($record) => $record->pegawaiAktif()->count())->heading('Jumlah Pegawai'),
            //                 Column::make('mataPelajaran_count')->getStateUsing(fn ($record) => $record->mataPelajaran()->count())->heading('Jumlah Mapel'),
            //             ])
            //             ->ignoreFormatting(),
            //     ])->icon(false),
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
