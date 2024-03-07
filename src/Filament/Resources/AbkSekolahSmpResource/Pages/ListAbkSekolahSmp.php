<?php

namespace Kanekescom\Simgtk\Filament\Resources\AbkSekolahSmpResource\Pages;

use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Kanekescom\Simgtk\Enums\StatusSekolahEnum;
use Kanekescom\Simgtk\Filament\Resources\AbkSekolahSmpResource;
use Kanekescom\Simgtk\Imports\SekolahRombelImport;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Spatie\LaravelOptions\Options;

class ListAbkSekolahSmp extends ListRecords
{
    protected static string $resource = AbkSekolahSmpResource::class;

    protected static ?string $title = 'ABK Sekolah SMP';

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
                ->label('Import Rombel')
                ->visible(auth()->user()->can('import_'.self::$resource)),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];

        $tabs[''] = Tab::make('All')
            ->badge(
                $this->getModel()::query()
                    ->where('jenjang_sekolah_id', JenjangSekolah::where('kode', 'smp')->first()?->id)
                    ->count()
            );

        $statusKepegawaians = Options::forEnum(StatusSekolahEnum::class)->toArray();

        foreach ($statusKepegawaians as $statusKepegawaian) {
            $tabs[$statusKepegawaian['value']] = Tab::make($statusKepegawaian['value'])
                ->badge(
                    $this->getModel()::query()
                        ->where('jenjang_sekolah_id', JenjangSekolah::where('kode', 'smp')->first()?->id)
                        ->where('status_kode', $statusKepegawaian['value'])
                        ->count()
                )
                ->modifyQueryUsing(function ($query) use ($statusKepegawaian) {
                    return $query
                        ->where('jenjang_sekolah_id', JenjangSekolah::where('kode', 'smp')->first()?->id)
                        ->where('status_kode', $statusKepegawaian['value']);
                })
                ->label($statusKepegawaian['label']);
        }

        return $tabs;
    }
}
