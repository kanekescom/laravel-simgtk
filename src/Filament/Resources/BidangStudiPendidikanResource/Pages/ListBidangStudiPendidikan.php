<?php

namespace Kanekescom\Simgtk\Filament\Resources\BidangStudiPendidikanResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\BidangStudiPendidikanResource;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListBidangStudiPendidikan extends ListRecords
{
    protected static string $resource = BidangStudiPendidikanResource::class;

    protected static ?string $title = 'Bidang Studi Pendidikan';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
