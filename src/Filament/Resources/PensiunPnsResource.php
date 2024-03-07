<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Kanekescom\Simgtk\Filament\Resources\PensiunPnsResource\Pages;
use Kanekescom\Simgtk\Filament\Traits\HasPensiunResource;
use Kanekescom\Simgtk\Models\PensiunPns;

class PensiunPnsResource extends PensiunResource implements HasShieldPermissions
{
    use HasPensiunResource;

    protected static ?string $slug = 'pensiun-pns';

    protected static ?string $pluralLabel = 'Pensiun PNS';

    protected static ?string $model = PensiunPns::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationLabel = 'PNS';

    protected static ?string $navigationGroup = 'Pensiun';

    public static function table(Table $table): Table
    {
        return self::defaultTable($table)
            ->modifyQueryUsing(fn (Builder $query) => $query->statusKepegawaianPns());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPensiunPns::route('/'),
            'edit' => Pages\EditPensiunPns::route('/{record}/edit'),
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
