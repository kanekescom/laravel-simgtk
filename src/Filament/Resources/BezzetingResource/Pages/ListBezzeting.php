<?php

namespace Kanekescom\Simgtk\Filament\Resources\BezzetingResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\BezzetingResource;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListBezzeting extends ListRecords
{
    protected static string $resource = BezzetingResource::class;

    protected static ?string $title = 'Bezzeting';

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
                        ])
                        ->ignoreFormatting(),
                ]),
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
