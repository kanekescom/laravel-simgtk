<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Kanekescom\Simgtk\Filament\Resources\SekolahResource\Pages;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\Sekolah;

class SekolahResource extends Resource
{
    protected static ?string $slug = 'sekolah';

    protected static ?string $pluralLabel = 'Sekolah';

    protected static ?string $model = Sekolah::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Sekolah';

    protected static ?string $navigationGroup = null;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->maxLength(255)
                    ->required()
                    ->columnSpanFull()
                    ->label('Nama'),
                Forms\Components\TextInput::make('npsn')
                    ->numeric()
                    ->length(8)
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->label('NPSN'),
                Forms\Components\Select::make('jenjang_sekolah_id')
                    ->relationship('jenjangSekolah', 'nama')
                    ->exists(table: JenjangSekolah::class, column: 'id')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Jenjang Sekolah'),
                Forms\Components\Select::make('wilayah_id')
                    ->relationship('wilayah', 'nama')
                    ->exists()
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Wilayah'),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup('wilayah.nama')
            ->defaultSort('nama', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('#')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('nama')
                    ->wrap()
                    ->grow()
                    ->searchable()
                    ->sortable('nama')
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('npsn')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->label('NPSN'),
                Tables\Columns\TextColumn::make('pegawai_aktif_count')
                    ->counts('pegawaiAktif')
                    ->alignEnd()
                    ->sortable()
                    ->label('Pegawai'),
                Tables\Columns\TextColumn::make('guru_aktif_count')
                    ->counts('guruAktif')
                    ->alignEnd()
                    ->sortable()
                    ->label('Guru'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenjang_sekolah')
                    ->relationship('jenjangSekolah', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Jenjang Sekolah'),
                Tables\Filters\SelectFilter::make('wilayah_id')
                    ->relationship('wilayah', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Wilayah'),
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
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSekolah::route('/'),
            'create' => Pages\CreateSekolah::route('/create'),
            'edit' => Pages\EditSekolah::route('/{record}/edit'),
        ];
    }
}
