<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kanekescom\Simgtk\Filament\Resources\MutasiResource\Pages;
use Kanekescom\Simgtk\Models\Mutasi;

class MutasiResource extends Resource
{
    protected static ?string $slug = 'mutasi';

    protected static ?string $pluralLabel = 'Mutasi';

    protected static ?string $model = Mutasi::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Mutasi';

    protected static ?string $navigationGroup = null;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('rancangan_mutasi_id')
                    ->relationship('rancangan', 'nama', modifyQueryUsing: fn (Builder $query) => $query->available())
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nama_tanggal}")
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Rancangan Mutasi'),
                Forms\Components\Select::make('pegawai_id')
                    ->relationship('pegawai', 'nama')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nama_id_gelar}")
                    ->searchable(['nama', 'nik', 'nuptk', 'nip'])
                    ->preload()
                    ->required()
                    ->label('Pegawai'),
                Forms\Components\Select::make('asal_sekolah_id')
                    ->relationship('asalSekolah', 'nama')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Asal Sekolah'),
                Forms\Components\Select::make('tujuan_sekolah_id')
                    ->relationship('tujuanSekolah', 'nama')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Tujuan Sekolah'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rancangan.nama')
                    ->description(fn (Mutasi $record): string => "{$record->tanggal_mulai} - $record->tanggal_berakhir")
                    ->searchable()
                    ->sortable()
                    ->hidden()
                    ->label('Rancangan Mutasi'),
                Tables\Columns\TextColumn::make('pegawai.nama_gelar')
                    ->description(fn (Mutasi $record): string => $record->pegawai?->nama_id)
                    ->searchable(['nama', 'nip', 'nik', 'nuptk'])
                    ->sortable(['pegawai.nama'])
                    ->label('Pegawai'),
                Tables\Columns\TextColumn::make('asalSekolah.nama')
                    ->searchable()
                    ->sortable()
                    ->hidden()
                    ->label('Asal Sekolah'),
                Tables\Columns\TextColumn::make('tujuanSekolah.nama')
                    ->description(fn (Mutasi $record): string => "Asal: {$record->asalSekolah?->nama}")
                    ->searchable()
                    ->sortable()
                    ->label('Sekolah Tujuan'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('pegawai_id')
                    ->relationship('pegawai', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Pegawai'),
                Tables\Filters\SelectFilter::make('asal_sekolah_id')
                    ->relationship('asalSekolah', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Asal Sekolah'),
                Tables\Filters\SelectFilter::make('tujuan_sekolah_id')
                    ->relationship('tujuanSekolah', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Tujuan Sekolah'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMutasi::route('/'),
            'create' => Pages\CreateMutasi::route('/create'),
            'edit' => Pages\EditMutasi::route('/{record}/edit'),
        ];
    }
}
