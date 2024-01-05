<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Kanekescom\Simgtk\Filament\Resources\PensiunResource\Pages;
use Kanekescom\Simgtk\Models\Pensiun;

class PensiunResource extends Resource
{
    protected static ?string $slug = 'pensiun';

    protected static ?string $pluralLabel = 'Pensiun';

    protected static ?string $model = Pensiun::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pensiun';

    protected static ?string $navigationGroup = null;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListPensiun::route('/'),
            'create' => Pages\CreatePensiun::route('/create'),
            'edit' => Pages\EditPensiun::route('/{record}/edit'),
        ];
    }
}
