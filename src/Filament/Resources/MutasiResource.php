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
                    ->relationship('rancangan', 'nama', modifyQueryUsing: fn (Builder $query) => $query->aktif())
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nama_tanggal}")
                    ->searchable()
                    ->preload()
                    ->required()
                    ->disabledOn('edit')
                    ->label('Rancangan Mutasi'),
                Forms\Components\Select::make('pegawai_id')
                    ->relationship('pegawai', 'nama')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nama_id_gelar}")
                    ->searchable(['nama', 'nik', 'nuptk', 'nip'])
                    ->preload()
                    ->required()
                    ->disabledOn('edit')
                    ->label('Pegawai'),
                Forms\Components\Select::make('asal_sekolah_id')
                    ->relationship('asalSekolah', 'nama')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nama_wilayah}")
                    ->searchable()
                    ->preload()
                    ->required()
                    ->hiddenOn('create')
                    ->disabledOn('edit')
                    ->label('Asal Sekolah'),
                Forms\Components\Select::make('asal_mata_pelajaran_id')
                    ->relationship('asalMataPelajaran', 'nama')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nama}")
                    ->searchable()
                    ->preload()
                    ->required()
                    ->hiddenOn('create')
                    ->disabledOn('edit')
                    ->label('Asal Mata Pelajaran'),
                Forms\Components\Select::make('tujuan_sekolah_id')
                    ->relationship('tujuanSekolah', 'nama')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nama_wilayah}")
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Tujuan Sekolah'),
                Forms\Components\Select::make('tujuan_mata_pelajaran_id')
                    ->relationship('tujuanMataPelajaran', 'nama')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nama}")
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Tujuan Mata Pelajaran'),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rancangan.nama')
                    ->description(fn (Mutasi $record): string => "{$record->rancangan?->periode_tanggal}")
                    ->searchable()
                    ->sortable()
                    ->label('Rancangan Mutasi'),
                Tables\Columns\TextColumn::make('pegawai.nama_gelar')
                    ->description(fn (Mutasi $record): string => $record->pegawai?->nama_id ?? '')
                    ->searchable(['nama', 'nip', 'nik', 'nuptk'])
                    ->sortable(['pegawai.nama'])
                    ->label('Pegawai'),
                Tables\Columns\TextColumn::make('asalSekolah.nama')
                    ->description(fn (Mutasi $record): string => "{$record->asalMataPelajaran?->nama}")
                    ->searchable()
                    ->sortable()
                    ->label('Sekolah Asal'),
                Tables\Columns\TextColumn::make('tujuanSekolah.nama')
                    ->description(fn (Mutasi $record): string => "{$record->tujuanMataPelajaran?->nama}")
                    ->searchable()
                    ->sortable()
                    ->label('Sekolah Tujuan'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('rancangan.nama')
                    ->relationship('rancangan', 'nama')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nama_tanggal}")
                    ->searchable()
                    ->preload()
                    ->label('Rancangan Mutasi'),
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
