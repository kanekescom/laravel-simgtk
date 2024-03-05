<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Kanekescom\Simgtk\Filament\Resources\AbkSekolahSdResource\Pages;
use Kanekescom\Simgtk\Filament\Traits\HasAbkSekolahResource;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\Sekolah;

class AbkSekolahSdResource extends Resource
{
    use HasAbkSekolahResource;

    protected static ?string $slug = 'referensi/bezetting/abk-sekolah-sd';

    protected static ?string $pluralLabel = 'ABK Sekolah SD';

    protected static ?string $model = Sekolah::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'ABK SD';

    protected static ?string $navigationGroup = 'Referensi Bezetting';

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
            ->modifyQueryUsing(fn (Builder $query) => $query->where('jenjang_sekolah_id', JenjangSekolah::where('kode', 'sd')->first()?->id));
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAbkSekolahSd::route('/'),
        ];
    }
}