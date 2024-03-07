<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Kanekescom\Simgtk\Filament\Resources\PensiunPppkResource\Pages;
use Kanekescom\Simgtk\Filament\Traits\HasPensiunResource;
use Kanekescom\Simgtk\Models\PensiunPppk;

class PensiunPppkResource extends PensiunResource implements HasShieldPermissions
{
    use HasPensiunResource;

    protected static ?string $slug = 'pensiun-pppk';

    protected static ?string $pluralLabel = 'Pensiun PPPK';

    protected static ?string $model = PensiunPppk::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationLabel = 'PPPK';

    protected static ?string $navigationGroup = 'Pensiun';

    public static function table(Table $table): Table
    {
        return self::defaultTable($table)
            ->modifyQueryUsing(fn (Builder $query) => $query->statusKepegawaianPppk());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPensiunPppk::route('/'),
            'edit' => Pages\EditPensiunPppk::route('/{record}/edit'),
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
