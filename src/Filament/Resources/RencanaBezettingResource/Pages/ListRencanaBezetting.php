<?php

namespace Kanekescom\Simgtk\Filament\Resources\RencanaBezettingResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\RencanaBezettingResource;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListRencanaBezetting extends ListRecords
{
    protected static string $resource = RencanaBezettingResource::class;

    protected static ?string $title = 'Rencana Bezetting';

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->fields([
                    ImportField::make('id')
                        ->rules('required|max:255')
                        ->label('ID'),
                    ImportField::make('nama')
                        ->rules('required|max:255')
                        ->label('Nama'),
                    ImportField::make('tanggal_mulai')
                        ->rules('required|date')
                        ->label('Nama'),
                    ImportField::make('tanggal_berakhir')
                        ->rules('required|after_or_equal:tanggal_mulai')
                        ->label('Nama'),
                    ImportField::make('is_aktif')
                        ->rules('boolean')
                        ->label('Aktif'),
                ]),
            ExportAction::make()
                ->exports([
                    ExcelExport::make()
                        ->withFilename(fn ($resource) => str($resource::getSlug())->replace('/', '_') . '-' . now()->format('Y-m-d'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                        ->withColumns([
                            Column::make('id')->heading('ID'),
                            Column::make('nama')->heading('Nama'),
                            Column::make('tanggal_mulai')->heading('Tanggal Mulai'),
                            Column::make('tanggal_berakhir')->heading('Tanggal Berakhir'),
                            Column::make('is_aktif')->heading('Aktif'),
                            Column::make('sekolah_count')->getStateUsing(fn ($record) => $record->sekolah()->count())->heading('Jumlah Sekolah'),
                        ])
                        ->ignoreFormatting(),
                ])->icon(false),
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}