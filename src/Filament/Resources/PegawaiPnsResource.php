<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Kanekescom\Simgtk\Filament\Resources\PegawaiPnsResource\Pages;
use Kanekescom\Simgtk\Filament\Traits\HasPegawaiResource;

class PegawaiPnsResource extends PegawaiResource
{
    use HasPegawaiResource;

    protected static ?string $slug = 'pegawai-pns';

    protected static ?string $pluralLabel = 'Pegawai PNS';

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
}
