<?php

namespace Kanekescom\Simgtk\Filament\Resources\BidangStudiSertifikasiResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\BidangStudiSertifikasiResource;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListBidangStudiSertifikasi extends ListRecords
{
    protected static string $resource = BidangStudiSertifikasiResource::class;

    protected static ?string $title = 'Bidang Studi Sertifikasi';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
