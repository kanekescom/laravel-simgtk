<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Kanekescom\Simgtk\Filament\Resources\PegawaiPppkResource\Pages;
use Kanekescom\Simgtk\Traits\HasPegawaiResource;

class PegawaiPppkResource extends PegawaiResource
{
    use HasPegawaiResource;

    protected static ?string $slug = 'pegawai-pppk';

    protected static ?string $pluralLabel = 'Pegawai PPPK';

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
}
