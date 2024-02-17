<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
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
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->label('Nama'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('nama', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('#')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('nama')
                    ->wrap()
                    ->grow()
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),
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
            'index' => Pages\ListBidangStudiSertifikasi::route('/'),
            'create' => Pages\CreateBidangStudiSertifikasi::route('/create'),
            'edit' => Pages\EditBidangStudiSertifikasi::route('/{record}/edit'),
        ];
    }
}
