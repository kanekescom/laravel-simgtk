<?php

namespace Kanekescom\Simgtk\Filament\Resources\AbkSekolahResource\Pages;

use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Kanekescom\Simgtk\Filament\Resources\AbkSekolahResource;
use Kanekescom\Simgtk\Imports\SekolahRombelImport;
use Kanekescom\Simgtk\Models\JenjangSekolah;

class ListAbkSekolah extends ListRecords
{
    protected static string $resource = AbkSekolahResource::class;

    protected static ?string $title = 'ABK Sekolah';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\Action::make('fix')
            //     ->requiresConfirmation()
            //     ->action(function () {
            //         try {
            //             Artisan::call('simgtk:fix-sekolah-abk');

            //             Notification::make()
            //                 ->title('Fixed successfully')
            //                 ->success()
            //                 ->send();
            //         } catch (\Throwable $e) {
            //             Notification::make()
            //                 ->title('Something went wrong')
            //                 ->danger()
            //                 ->body($e->getMessage())
            //                 ->send();

            //             Log::error($e->getMessage());
            //         }
            //     }),
            ExcelImportAction::make()
                ->use(SekolahRombelImport::class)
                ->slideOver()
                ->icon(false)
                ->label('Import Rombel'),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];

        $jenjangSekolahs = JenjangSekolah::all();

        foreach ($jenjangSekolahs as $jenjangSekolah) {
            $tabs[$jenjangSekolah->kode] = Tab::make($jenjangSekolah->id)
                ->badge(
                    $this->getModel()::query()
                        ->where('jenjang_sekolah_id', $jenjangSekolah->id)
                        ->count()
                )
                ->modifyQueryUsing(function ($query) use ($jenjangSekolah) {
                    return $query
                        ->where('jenjang_sekolah_id', $jenjangSekolah->id);
                })
                ->label($jenjangSekolah->nama);
        }

        return $tabs;
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return JenjangSekolah::first()->kode;
    }
}
