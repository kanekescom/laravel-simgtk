<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Kanekescom\Simgtk\Filament\Resources\JenjangSekolahResource\Pages;
use Kanekescom\Simgtk\Models\JenjangSekolah;

class JenjangSekolahResource extends Resource
{
    protected static ?string $slug = 'referensi/kependidikan/jenjang-sekolah';

    protected static ?string $pluralLabel = 'Jenjang Sekolah';

    protected static ?string $model = JenjangSekolah::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Jenjang Sekolah';

    protected static ?string $navigationGroup = 'Referensi Kependidikan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->label('Kode'),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama'),
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
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->emptyStateActions([
                // Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListJenjangSekolah::route('/'),
            // 'create' => Pages\CreateJenjangSekolah::route('/create'),
            // 'edit' => Pages\EditJenjangSekolah::route('/{record}/edit'),
        ];
    }
}
