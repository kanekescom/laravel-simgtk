<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Kanekescom\Simgtk\Filament\Resources\UsulMutasiResource\Pages;
use Kanekescom\Simgtk\Models\RencanaMutasi;
use Kanekescom\Simgtk\Models\Sekolah;
use Kanekescom\Simgtk\Models\UsulMutasi;

class UsulMutasiResource extends Resource
{
    protected static ?string $slug = 'usul-mutasi';

    protected static ?string $pluralLabel = 'Usul Mutasi';

    protected static ?string $model = UsulMutasi::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Usul Mutasi';

    protected static ?string $navigationGroup = null;

    public static function canCreate(): bool
    {
        return RencanaMutasi::periodeAktif()->exists();
    }

    public static function canEdit(Model $record): bool
    {
        return RencanaMutasi::periodeAktif()->exists();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('rencana_mutasi_id')
                    ->relationship('rencana', 'nama', modifyQueryUsing: fn (Builder $query, $operation) => $operation == 'create' ? $query->periodeAktif() : $query)
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nama_periode}")
                    ->searchable()
                    ->preload()
                    ->required()
                    ->disabledOn('edit')
                    ->label('Rencana Mutasi'),
                Forms\Components\Select::make('pegawai_id')
                    ->relationship('pegawai', 'nama', modifyQueryUsing: fn (Builder $query, $operation) => $operation == 'create' ? $query->aktif() : $query)
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
                    ->relationship('tujuanMataPelajaran', 'nama', modifyQueryUsing: fn (Builder $query, Get $get) => $query->jenjangSekolahBy(Sekolah::where('id', $get('tujuan_sekolah_id'))->first()?->jenjang_sekolah_id))
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nama}")
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Tujuan Mata Pelajaran'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('#')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('pegawai.nama_gelar')
                    ->description(fn (Model $record): string => $record->pegawai?->nama_id ?? '')
                    ->wrap()
                    ->searchable(['nama', 'nip', 'nuptk', 'nik'])
                    ->sortable(['pegawai.nama'])
                    ->label('Pegawai'),
                Tables\Columns\TextColumn::make('asalSekolah.nama')
                    ->description(fn (Model $record): string => "{$record->asalMataPelajaran?->nama}")
                    ->wrap()
                    ->grow()
                    ->searchable()
                    ->sortable()
                    ->label('Sekolah Asal'),
                Tables\Columns\TextColumn::make('tujuanSekolah.nama')
                    ->description(fn (Model $record): string => "{$record->tujuanMataPelajaran?->nama}")
                    ->wrap()
                    ->grow()
                    ->searchable()
                    ->sortable()
                    ->label('Sekolah Tujuan'),
            ])
            ->filtersFormColumns(2)
            ->filters([
                Tables\Filters\SelectFilter::make('pegawai_id')
                    ->relationship('pegawai', 'nama', modifyQueryUsing: fn (Builder $query) => $query->aktif())
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nama_id_gelar}")
                    ->columnSpanFull()
                    ->searchable()
                    ->preload()
                    ->label('Pegawai'),
                Tables\Filters\SelectFilter::make('asal_sekolah_id')
                    ->relationship('asalSekolah', 'nama')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nama_wilayah}")
                    ->searchable()
                    ->preload()
                    ->label('Asal Sekolah'),
                Tables\Filters\SelectFilter::make('asal_mata_pelajaran_id')
                    ->relationship('asalMataPelajaran', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Asal Mapel'),
                Tables\Filters\SelectFilter::make('tujuan_sekolah_id')
                    ->relationship('tujuanSekolah', 'nama')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nama_wilayah}")
                    ->searchable()
                    ->preload()
                    ->label('Tujuan Sekolah'),
                Tables\Filters\SelectFilter::make('tujuan_mata_pelajaran_id')
                    ->relationship('tujuanMataPelajaran', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Tujuan Mapel'),
                Tables\Filters\TrashedFilter::make(),
            ])

            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->aktif()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsulMutasi::route('/'),
            'create' => Pages\CreateUsulMutasi::route('/create'),
            'edit' => Pages\EditUsulMutasi::route('/{record}/edit'),
        ];
    }
}
