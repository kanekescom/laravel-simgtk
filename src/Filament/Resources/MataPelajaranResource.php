<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Kanekescom\Simgtk\Filament\Resources\MataPelajaranResource\Pages;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\MataPelajaran;

class MataPelajaranResource extends Resource
{
    protected static ?string $slug = 'referensi/kependidikan/mata-pelajaran';

    protected static ?string $pluralLabel = 'Mata Pelajaran';

    protected static ?string $model = MataPelajaran::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Mata Pelajaran';

    protected static ?string $navigationGroup = 'Referensi Kependidikan';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function canForceDelete(Model $record): bool
    {
        return false;
    }

    public static function canForceDeleteAny(): bool
    {
        return false;
    }

    public static function canReorder(): bool
    {
        return false;
    }

    public static function canReplicate(Model $record): bool
    {
        return false;
    }

    public static function canRestore(Model $record): bool
    {
        return false;
    }

    public static function canRestoreAny(): bool
    {
        return false;
    }

    public static function canView(Model $record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('jenjang_sekolah_id')
                    ->relationship('jenjangSekolah', 'nama')
                    ->exists(table: JenjangSekolah::class, column: 'id')
                    ->disabled()
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Jenjang Sekolah'),
                Forms\Components\TextInput::make('kode')
                    ->required()
                    ->label('Kode'),
                Forms\Components\TextInput::make('nama')
                    ->disabled()
                    ->required()
                    ->maxLength(255)
                    ->label('Nama'),
                // Forms\Components\TextInput::make('singkatan')
                //     ->disabled()
                //     ->maxLength(255)
                //     ->label('Singkatan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('nama', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('#')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('jenjangSekolah.nama')
                    ->visible(fn ($livewire) => blank($livewire->activeTab))
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->label('Jenjang Sekolah'),
                Tables\Columns\TextColumn::make('nama')
                    ->description(fn (Model $record): string => "{$record->kode}")
                    ->wrap()
                    ->grow()
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),
                // Tables\Columns\TextColumn::make('singkatan')
                //     ->wrap()
                //     ->searchable()
                //     ->sortable()
                //     ->label('Singkatan'),
                // Tables\Columns\TextColumn::make('pegawai_aktif_count')
                //     ->counts('pegawaiAktif')
                //     ->alignEnd()
                //     ->sortable()
                //     ->label('Pegawai'),
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
            'index' => Pages\ListMataPelajaran::route('/'),
            'create' => Pages\CreateMataPelajaran::route('/create'),
            'edit' => Pages\EditMataPelajaran::route('/{record}/edit'),
        ];
    }
}
