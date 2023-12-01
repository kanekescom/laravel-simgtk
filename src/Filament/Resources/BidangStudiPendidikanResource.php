<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Kanekescom\Simgtk\Filament\Resources\BidangStudiPendidikanResource\Pages;
use Kanekescom\Simgtk\Models\BidangStudiPendidikan;

class BidangStudiPendidikanResource extends Resource
{
    protected static ?string $slug = 'referensi/kependidikan/bidang-studi-pendidikan';

    protected static ?string $pluralLabel = 'Bidang Studi Pendidikan';

    protected static ?string $model = BidangStudiPendidikan::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Bidang Studi Pendidikan';

    protected static ?string $navigationGroup = 'Referensi Kependidikan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
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
            ])
            ->filters([
                //
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
            'index' => Pages\ListBidangStudiPendidikans::route('/'),
            'create' => Pages\CreateBidangStudiPendidikan::route('/create'),
            'edit' => Pages\EditBidangStudiPendidikan::route('/{record}/edit'),
        ];
    }
}
