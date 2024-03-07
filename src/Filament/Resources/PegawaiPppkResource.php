<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Kanekescom\Simgtk\Filament\Resources\PegawaiPppkResource\Pages;
use Kanekescom\Simgtk\Filament\Traits\HasPegawaiResource;
use Kanekescom\Simgtk\Models\PegawaiPppk;

class PegawaiPppkResource extends PegawaiResource implements HasShieldPermissions
{
    use HasPegawaiResource;

    protected static ?string $slug = 'pegawai-pppk';

    protected static ?string $pluralLabel = 'Pegawai PPPK';

    protected static ?string $model = PegawaiPppk::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationLabel = 'PPPK';

    protected static ?string $navigationGroup = 'Pegawai';

    public static function table(Table $table): Table
    {
        return self::defaultTable($table)
            ->modifyQueryUsing(fn (Builder $query) => $query->aktif()->StatusKepegawaianPppk());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPegawaiPppk::route('/'),
            'create' => Pages\CreatePegawaiPppk::route('/create'),
            'edit' => Pages\EditPegawaiPppk::route('/{record}/edit'),
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
