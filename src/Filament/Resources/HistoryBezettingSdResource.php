<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Kanekescom\Simgtk\Filament\Resources\HistoryBezettingSdResource\Pages;
use Kanekescom\Simgtk\Filament\Traits\HasHistoryBezettingResource;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\RancanganBezetting;

class HistoryBezettingSdResource extends Resource
{
    use HasHistoryBezettingResource;

    protected static ?string $slug = 'history-bezetting-sd';

    protected static ?string $pluralLabel = 'History Bezetting SD';

    protected static ?string $model = RancanganBezetting::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'History Bezetting SD';

    protected static ?string $navigationGroup = null;

    protected static array $jenjangMapelHeaders = [
        'sd' => [
            'kelas' => 'KELAS',
            'penjaskes' => 'PENJASKES',
            'agama' => 'AGAMA',
            'agama_noni' => 'AGAMA NONI',
        ],
    ];

    protected static array $jenjangMapels = [
        'sd' => [
            'kelas',
            'penjaskes',
            'agama',
            'agama_noni',
        ],
    ];

    public static function table(Table $table): Table
    {
        return self::defaultTable($table)
            ->modifyQueryUsing(fn (Builder $query) => $query->aktif()->where('jenjang_sekolah_id', JenjangSekolah::where('kode', 'sd')->first()?->id));
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHistoryBezettingSd::route('/'),
        ];
    }
}
