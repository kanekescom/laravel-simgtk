<?php

namespace Kanekescom\Simgtk\Filament\Resources\RencanaBezzetingResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\RencanaBezzetingResource;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListRencanaBezzeting extends ListRecords
{
    protected static string $resource = RencanaBezzetingResource::class;

    protected static ?string $title = 'Rencana Bezzeting';

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
                        ->label('Nama'),
                ]),
            ExportAction::make()
                ->exports([
                    ExcelExport::make()
                        ->withFilename(fn ($resource) => str($resource::getSlug())->replace('/', '_') . '-' . now()->format('Y-m-d'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                        ->withColumns([
                            Column::make('id')->heading('ID'),
                            Column::make('nama')->heading('Nama'),
                        ])
                        ->ignoreFormatting(),
                ])->icon(false),
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
