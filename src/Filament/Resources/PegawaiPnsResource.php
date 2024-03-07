<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Kanekescom\Simgtk\Filament\Resources\PegawaiPnsResource\Pages;
use Kanekescom\Simgtk\Filament\Traits\HasPegawaiResource;
use Kanekescom\Simgtk\Models\PegawaiPns;

class PegawaiPnsResource extends PegawaiResource implements HasShieldPermissions
{
    use HasPegawaiResource;

    protected static ?string $slug = 'pegawai-pns';

    protected static ?string $pluralLabel = 'Pegawai PNS';

    protected static ?string $model = PegawaiPns::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationLabel = 'PNS';

    protected static ?string $navigationGroup = 'Pegawai';

    public static function table(Table $table): Table
    {
        return self::defaultTable($table)
            ->modifyQueryUsing(fn (Builder $query) => $query->aktif()->StatusKepegawaianPns());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPegawaiPns::route('/'),
            'create' => Pages\CreatePegawaiPns::route('/create'),
            'edit' => Pages\EditPegawaiPns::route('/{record}/edit'),
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
