<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Kanekescom\Simgtk\Filament\Resources\PegawaiNonAsnResource\Pages;
use Kanekescom\Simgtk\Filament\Traits\HasPegawaiResource;

class PegawaiNonAsnResource extends PegawaiResource
{
    use HasPegawaiResource;

    protected static ?string $slug = 'pegawai-nonasn';

    protected static ?string $pluralLabel = 'Pegawai NonASN';

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
}
