<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Kanekescom\Simgtk\Filament\Resources\HistoryBezettingSmpResource\Pages;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\RancanganBezetting;
use Kanekescom\Simgtk\Traits\HasHistoryBezettingResource;

class HistoryBezettingSmpResource extends Resource
{
    use HasHistoryBezettingResource;

    protected static ?string $slug = 'history-bezetting-smp';

    protected static ?string $pluralLabel = 'History Bezetting SMP';

    protected static ?string $model = RancanganBezetting::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'History Bezetting SMP';

    protected static ?string $navigationGroup = null;

    protected static array $jenjangMapelHeaders = [
        'smp' => [
            'pai' => 'PAI',
            'pjok' => 'PJOK',
            'b_indonesia' => 'B. INDONESIA',
            'b_inggris' => 'B. INGGRIS',
            'bk' => 'BK',
            'ipa' => 'IPA',
            'ips' => 'IPS',
            'matematika' => 'MATEMATIKA',
            'ppkn' => 'PPKN',
            'prakarya' => 'PRAKARYA',
            'seni_budaya' => 'SENI BUDAYA',
            'b_sunda' => 'B. SUNDA',
            'tik' => 'TIK',
        ],
    ];

    protected static array $jenjangMapels = [
        'smp' => [
            'pai',
            'pjok',
            'b_indonesia',
            'b_inggris',
            'bk',
            'ipa',
            'ips',
            'matematika',
            'ppkn',
            'prakarya',
            'seni_budaya',
            'b_sunda',
            'tik',
        ],
    ];

    public static function table(Table $table): Table
    {
        return self::defaultTable($table)
            ->modifyQueryUsing(fn (Builder $query) => $query->aktif()->where('jenjang_sekolah_id', JenjangSekolah::where('kode', 'smp')->first()?->id));
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHistoryBezettingSmp::route('/'),
        ];
    }
}
