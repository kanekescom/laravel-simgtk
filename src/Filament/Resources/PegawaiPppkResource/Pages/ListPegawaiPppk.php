<?php

namespace Kanekescom\Simgtk\Filament\Resources\PegawaiPppkResource\Pages;

use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Kanekescom\Simgtk\Filament\Resources\PegawaiPppkResource;
use Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Pages\ListPegawai;
use Kanekescom\Simgtk\Imports\PegawaiDapodikImport;

class ListPegawaiPppk extends ListPegawai
{
    protected static string $resource = PegawaiPppkResource::class;

    protected static ?string $title = 'Pegawai PPPK';

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
