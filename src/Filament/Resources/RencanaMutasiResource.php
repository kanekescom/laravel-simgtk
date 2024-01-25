<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Kanekescom\Simgtk\Filament\Resources\RencanaMutasiResource\Pages;
use Kanekescom\Simgtk\Models\RencanaMutasi;

class RencanaMutasiResource extends Resource
{
    protected static ?string $slug = 'rencana-mutasi';

    protected static ?string $pluralLabel = 'Rencana Mutasi';

    protected static ?string $model = RencanaMutasi::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Rencana Mutasi';

    protected static ?string $navigationGroup = 'Referensi Mutasi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->maxLength(255)
                    ->required()
                    ->columnSpanFull()
                    ->label('Nama'),
                Forms\Components\DatePicker::make('tanggal_mulai')
                    ->date()
                    ->required()
                    ->label('Tanggal Mulai'),
                Forms\Components\DatePicker::make('tanggal_berakhir')
                    ->date()
                    ->required()
                    ->label('Tanggal Berakhir'),
                Forms\Components\Toggle::make('is_aktif')
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
                Tables\Columns\ToggleColumn::make('is_aktif')
                    ->sortable()
                    ->label('Selesai'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_aktif')
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
            'index' => Pages\ListRencanaMutasi::route('/'),
            'create' => Pages\CreateRencanaMutasi::route('/create'),
            'edit' => Pages\EditRencanaMutasi::route('/{record}/edit'),
        ];
    }
}
