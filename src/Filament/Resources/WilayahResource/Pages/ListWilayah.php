<?php

namespace Kanekescom\Simgtk\Filament\Resources\WilayahResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\WilayahResource;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListWilayah extends ListRecords
{
    protected static string $resource = WilayahResource::class;

    protected static ?string $title = 'Wilayah';

    protected function getHeaderActions(): array
    {
        return [
            // ImportAction::make()
            //     ->fields([
            //         ImportField::make('id')
            //             ->rules('required|max:255')
            //             ->label('ID'),
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
            //                 Column::make('nama')->heading('Nama'),
            //                 Column::make('sekolah_count')->getStateUsing(fn ($record) => $record->sekolah()->count())->heading('Jumlah Sekolah'),
            //                 Column::make('pegawai_aktif_count')->getStateUsing(fn ($record) => $record->pegawaiAktif()->count())->heading('Jumlah Pegawai'),
            //             ])
            //             ->ignoreFormatting(),
            //     ])->icon(false),
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
