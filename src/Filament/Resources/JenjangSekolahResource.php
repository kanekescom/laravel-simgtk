<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
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
                    ->description(fn (Model $record): string => "{$record->kode}")
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('sekolah_count')
                    ->counts('sekolah')
                    ->alignment(Alignment::End)
                    ->label('Sekolah'),
                Tables\Columns\TextColumn::make('pegawai_aktif_count')
                    ->counts('pegawaiAktif')
                    ->alignment(Alignment::End)
                    ->label('Pegawai'),
                Tables\Columns\TextColumn::make('mata_pelajaran_count')
                    ->counts('mataPelajaran')
                    ->alignment(Alignment::End)
                    ->label('Mapel'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
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
            'index' => Pages\ListJenjangSekolah::route('/'),
            'create' => Pages\CreateJenjangSekolah::route('/create'),
            'edit' => Pages\EditJenjangSekolah::route('/{record}/edit'),
        ];
    }
}
