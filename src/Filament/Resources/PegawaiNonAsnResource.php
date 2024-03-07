<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Kanekescom\Simgtk\Filament\Resources\PegawaiNonAsnResource\Pages;
use Kanekescom\Simgtk\Filament\Traits\HasPegawaiResource;
use Kanekescom\Simgtk\Models\PegawaiNonAsn;

class PegawaiNonAsnResource extends PegawaiResource implements HasShieldPermissions
{
    use HasPegawaiResource;

    protected static ?string $slug = 'pegawai-nonasn';

    protected static ?string $pluralLabel = 'Pegawai NonASN';

    protected static ?string $model = PegawaiNonAsn::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationLabel = 'NonASN';

    protected static ?string $navigationGroup = 'Pegawai';

    public static function table(Table $table): Table
    {
        return self::defaultTable($table)
            ->modifyQueryUsing(fn (Builder $query) => $query->aktif()->StatusKepegawaianNonAsn());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPegawaiNonAsn::route('/'),
            'create' => Pages\CreatePegawaiNonAsn::route('/create'),
            'edit' => Pages\EditPegawaiNonAsn::route('/{record}/edit'),
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
