<?php

namespace Kanekescom\Simgtk\Filament\Resources\SekolahSmpResource\Pages;

use Filament\Resources\Components\Tab;
use Kanekescom\Simgtk\Enums\StatusSekolahEnum;
use Kanekescom\Simgtk\Filament\Resources\SekolahResource\Pages\ListSekolah;
use Kanekescom\Simgtk\Filament\Resources\SekolahSmpResource;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Spatie\LaravelOptions\Options;

class ListSekolahSmp extends ListSekolah
{
    protected static string $resource = SekolahSmpResource::class;

    protected static ?string $title = 'Sekolah SMP';

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
