<?php

namespace Kanekescom\Simgtk\Filament\Resources\PegawaiNonAsnResource\Pages;

use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Kanekescom\Simgtk\Filament\Resources\PegawaiNonAsnResource;
use Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Pages\ListPegawai;
use Kanekescom\Simgtk\Imports\PegawaiDapodikImport;

class ListPegawaiNonAsn extends ListPegawai
{
    protected static string $resource = PegawaiNonAsnResource::class;

    protected static ?string $title = 'Pegawai NonASN';

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->use(PegawaiDapodikImport::class)
                ->slideOver()
                ->icon(false)
                ->label('Import')
                ->visible(auth()->user()->can('import_'.self::$resource)),
            Actions\CreateAction::make()->label('Create'),
        ];
    }

    public function getTabs(): array
    {
        return [];
    }
}
