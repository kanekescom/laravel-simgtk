<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Kanekescom\Simgtk\Filament\Resources\PensiunNonAsnResource\Pages;
use Kanekescom\Simgtk\Filament\Traits\HasPensiunResource;

class PensiunNonAsnResource extends PensiunResource
{
    use HasPensiunResource;

    protected static ?string $slug = 'pensiun-nonasn';

    protected static ?string $pluralLabel = 'Pensiun NonASN';

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationLabel = 'NonASN';

    protected static ?string $navigationGroup = 'Pensiun';

    public static function table(Table $table): Table
    {
        return self::defaultTable($table)
            ->modifyQueryUsing(fn (Builder $query) => $query->statusKepegawaianNonAsn());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPensiunNonAsn::route('/'),
            'edit' => Pages\EditPensiunNonAsn::route('/{record}/edit'),
        ];
    }
}
