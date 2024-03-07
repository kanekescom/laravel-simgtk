<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Kanekescom\Simgtk\Filament\Resources\AbkSekolahSmpResource\Pages;
use Kanekescom\Simgtk\Filament\Traits\HasAbkSekolahResource;
use Kanekescom\Simgtk\Models\AbkSekolahSmp;
use Kanekescom\Simgtk\Models\JenjangSekolah;

class AbkSekolahSmpResource extends Resource implements HasShieldPermissions
{
    use HasAbkSekolahResource;

    protected static ?string $slug = 'referensi/bezetting/abk-sekolah-smp';

    protected static ?string $pluralLabel = 'ABK Sekolah SMP';

    protected static ?string $model = AbkSekolahSmp::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'ABK SMP';

    protected static ?string $navigationGroup = 'Referensi Bezetting';

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
            ->modifyQueryUsing(fn (Builder $query) => $query->where('jenjang_sekolah_id', JenjangSekolah::where('kode', 'smp')->first()?->id));
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAbkSekolahSmp::route('/'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'restore',
            'restore_any',
            'replicate',
            'reorder',
            'delete',
            'delete_any',
            'force_delete',
            'force_delete_any',
            'import',
            'export',
        ];
    }
}
