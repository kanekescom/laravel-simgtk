<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Kanekescom\Simgtk\Filament\Resources\RancanganMutasiResource\Pages;
use Kanekescom\Simgtk\Models\RancanganMutasi;

class RancanganMutasiResource extends Resource
{
    protected static ?string $slug = 'rancangan-mutasi';

    protected static ?string $pluralLabel = 'Rancangan Mutasi';

    protected static ?string $model = RancanganMutasi::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Rancangan Mutasi';

    protected static ?string $navigationGroup = 'Referensi Mutasi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->maxLength(255)
                    ->required()
                    ->label('Nama'),
                Forms\Components\DatePicker::make('tanggal_mulai')
                    ->date()
                    ->required()
                    ->label('Tanggal Mulai'),
                Forms\Components\DatePicker::make('tanggal_berakhir')
                    ->date()
                    ->required()
                    ->label('Tanggal Berakhir'),
                Forms\Components\Toggle::make('is_selesai')
                    ->label('Selesai'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('tanggal_mulai')
                    ->searchable()
                    ->sortable()
                    ->label('Mulai'),
                Tables\Columns\TextColumn::make('tanggal_berakhir')
                    ->searchable()
                    ->sortable()
                    ->label('Berakhir'),
                Tables\Columns\IconColumn::make('is_selesai')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark')
                    ->label('Selesai'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_selesai')
                    ->label('Selesai'),
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
            'index' => Pages\ListRancanganMutasi::route('/'),
            'create' => Pages\CreateRancanganMutasi::route('/create'),
            'edit' => Pages\EditRancanganMutasi::route('/{record}/edit'),
        ];
    }
}
