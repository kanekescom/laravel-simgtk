<?php

namespace Kanekescom\Simgtk\Filament\Resources\AbkSekolahSdResource\Pages;

use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Enums\StatusSekolahEnum;
use Kanekescom\Simgtk\Filament\Resources\AbkSekolahSdResource;
use Kanekescom\Simgtk\Imports\SekolahRombelImport;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Spatie\LaravelOptions\Options;

class ListAbkSekolahSd extends ListRecords
{
    protected static string $resource = AbkSekolahSdResource::class;

    protected static ?string $title = 'ABK Sekolah SD';

    protected function getHeaderActions(): array
    {
        return [
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

        $tabs[''] = Tab::make('All')
            ->badge(
                $this->getModel()::query()
                    ->where('jenjang_sekolah_id', JenjangSekolah::where('kode', 'sd')->first()?->id)
                    ->count()
            );

        $statusKepegawaians = Options::forEnum(StatusSekolahEnum::class)->toArray();

        foreach ($statusKepegawaians as $statusKepegawaian) {
            $tabs[$statusKepegawaian['value']] = Tab::make($statusKepegawaian['value'])
                ->badge(
                    $this->getModel()::query()
                        ->where('jenjang_sekolah_id', JenjangSekolah::where('kode', 'sd')->first()?->id)
                        ->where('status_kode', $statusKepegawaian['value'])
                        ->count()
                )
                ->modifyQueryUsing(function ($query) use ($statusKepegawaian) {
                    return $query
                        ->where('jenjang_sekolah_id', JenjangSekolah::where('kode', 'sd')->first()?->id)
                        ->where('status_kode', $statusKepegawaian['value']);
                })
                ->label($statusKepegawaian['label']);
        }

        return $tabs;
    }
}
