<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Kanekescom\Simgtk\Filament\Resources\SekolahResource\Pages;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\Sekolah;

class SekolahResource extends Resource
{
    protected static ?string $slug = 'referensi/sekolah';

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
                    ->label('Nama')
                    ->maxLength(255)
                    ->required(),
                Forms\Components\TextInput::make('npsn')
                    ->label('NPSN')
                    ->numeric()
                    ->length(8)
                    ->unique(ignoreRecord: true)
                    ->required(),
                Forms\Components\Select::make('jenjang_sekolah_id')
                    ->label('Jenjang Sekolah')
                    ->relationship('jenjangSekolah', 'nama')
                    ->exists(table: JenjangSekolah::class, column: 'id')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('wilayah_kode')
                    ->label('Wilayah')
                    ->relationship('wilayah', 'nama')
                    ->exists()
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('jumlah_kelas')
                    ->label('Jumlah Kelas')
                    ->integer()
                    ->maxValue(100)
                    ->required(),
                Forms\Components\TextInput::make('jumlah_rombel')
                    ->label('Jumlah Rombel')
                    ->integer()
                    ->maxValue(100)
                    ->required(),
                Forms\Components\TextInput::make('jumlah_siswa')
                    ->label('Jumlah Siswa')
                    ->integer()
                    ->maxValue(10000)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('npsn')
                    ->label('NPSN')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenjangSekolah.nama')
                    ->label('Jenjang Sekolah')
                    ->searchable()
                    ->sortable()
                    ->hidden(),
                Tables\Columns\TextColumn::make('wilayah.nama')
                    ->label('Wilayah')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_kelas')
                    ->label('Kelas')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_rombel')
                    ->label('Rombel')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_siswa')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenjang_sekolah')
                    ->label('Jenjang Sekolah')
                    ->relationship('jenjangSekolah', 'nama')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('wilayah_kode')
                    ->label('Wilayah')
                    ->relationship('wilayah', 'nama')
                    ->searchable()
                    ->preload(),
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
            'index' => Pages\ListSekolahs::route('/'),
            'create' => Pages\CreateSekolah::route('/create'),
            'edit' => Pages\EditSekolah::route('/{record}/edit'),
        ];
    }
}
