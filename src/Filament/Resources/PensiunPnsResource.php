<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Kanekescom\Simgtk\Filament\Resources\PensiunPnsResource\Pages;
use Kanekescom\Simgtk\Filament\Traits\HasPensiunResource;

class PensiunPnsResource extends PensiunResource
{
    use HasPensiunResource;

    protected static ?string $slug = 'pensiun-pns';

    protected static ?string $pluralLabel = 'Pensiun PNS';

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
}
