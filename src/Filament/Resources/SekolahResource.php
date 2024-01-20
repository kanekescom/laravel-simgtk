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
                Forms\Components\Select::make('wilayah_kode')
                    ->relationship('wilayah', 'nama')
                    ->exists()
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Wilayah'),
                Forms\Components\TextInput::make('jumlah_kelas')
                    ->integer()
                    ->minValue(0)
                    ->maxValue(10000)
                    ->required()
                    ->label('Jumlah Kelas'),
                Forms\Components\TextInput::make('jumlah_rombel')
                    ->integer()
                    ->minValue(0)
                    ->maxValue(10000)
                    ->required()
                    ->label('Jumlah Rombel'),
                Forms\Components\TextInput::make('jumlah_siswa')
                    ->integer()
                    ->minValue(0)
                    ->maxValue(10000)
                    ->required()
                    ->label('Jumlah Siswa'),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('npsn')
                    ->searchable()
                    ->sortable()
                    ->label('NPSN'),
                Tables\Columns\TextColumn::make('wilayah.nama')
                    ->searchable()
                    ->sortable()
                    ->label('Wilayah'),
                Tables\Columns\TextColumn::make('jumlah_kelas')
                    ->searchable()
                    ->sortable()
                    ->label('Kelas'),
                Tables\Columns\TextColumn::make('jumlah_rombel')
                    ->searchable()
                    ->sortable()
                    ->label('Rombel'),
                Tables\Columns\TextColumn::make('jumlah_siswa')
                    ->searchable()
                    ->sortable()
                    ->label('Siswa'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenjang_sekolah')
                    ->relationship('jenjangSekolah', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Jenjang Sekolah'),
                Tables\Filters\SelectFilter::make('wilayah_kode')
                    ->relationship('wilayah', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Wilayah'),
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
            'index' => Pages\ListSekolah::route('/'),
            'create' => Pages\CreateSekolah::route('/create'),
            'edit' => Pages\EditSekolah::route('/{record}/edit'),
        ];
    }
}
