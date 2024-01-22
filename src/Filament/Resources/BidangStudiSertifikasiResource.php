<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Kanekescom\Simgtk\Filament\Resources\BidangStudiSertifikasiResource\Pages;
use Kanekescom\Simgtk\Models\BidangStudiSertifikasi;

class BidangStudiSertifikasiResource extends Resource
{
    protected static ?string $slug = 'referensi/kependidikan/bidang-studi-sertifikasi';

    protected static ?string $pluralLabel = 'Bidang Studi Sertifikasi';

    protected static ?string $model = BidangStudiSertifikasi::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Bidang Studi Sertifikasi';

    protected static ?string $navigationGroup = 'Referensi Kependidikan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
            'index' => Pages\ListBidangStudiSertifikasi::route('/'),
            // 'create' => Pages\CreateBidangStudiSertifikasi::route('/create'),
            // 'edit' => Pages\EditBidangStudiSertifikasi::route('/{record}/edit'),
        ];
    }
}
