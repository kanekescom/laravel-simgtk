<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Kanekescom\Simgtk\Filament\Resources\RencanaBezettingResource\Pages;
use Kanekescom\Simgtk\Models\RencanaBezetting;

class RencanaBezettingResource extends Resource
{
    protected static ?string $slug = 'referensi/bezetting/rencana-bezetting';

    protected static ?string $pluralLabel = 'Rencana Bezetting';

    protected static ?string $model = RencanaBezetting::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Rencana';

    protected static ?string $navigationGroup = 'Referensi Bezetting';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->columnSpanFull()
                    ->label('Nama'),
                // Forms\Components\DatePicker::make('tanggal_mulai')
                //     ->date()
                //     ->required()
                //     ->label('Tanggal Mulai'),
                // Forms\Components\DatePicker::make('tanggal_berakhir')
                //     ->afterOrEqual('tanggal_mulai')
                //     ->required()
                //     ->label('Tanggal Berakhir'),
                Forms\Components\Toggle::make('is_aktif')
                    ->label('Aktif'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('#')->state(
                    static function (HasTable $livewire, $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * (
                                $livewire->getTablePage() - 1
                            ))
                        );
                    }
                ),
                Tables\Columns\TextColumn::make('nama')
                    ->wrap()
                    ->grow()
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),
                // Tables\Columns\TextColumn::make('tanggal_mulai')
                //     ->searchable()
                //     ->sortable()
                //     ->label('Mulai'),
                // Tables\Columns\TextColumn::make('tanggal_berakhir')
                //     ->searchable()
                //     ->sortable()
                //     ->label('Berakhir'),
                Tables\Columns\ToggleColumn::make('is_aktif')
                    ->sortable()
                    ->label('Aktif'),
                Tables\Columns\TextColumn::make('sekolah_count')
                    ->counts('sekolah')
                    ->alignment(Alignment::End)
                    ->label('Sekolah'),
                Tables\Columns\TextColumn::make('pegawai_count')
                    ->counts('pegawai')
                    ->alignment(Alignment::End)
                    ->label('Pegawai'),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->label('Tanggal'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_aktif')
                    ->label('Aktif'),
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
            'index' => Pages\ListRencanaBezetting::route('/'),
            'create' => Pages\CreateRencanaBezetting::route('/create'),
            'edit' => Pages\EditRencanaBezetting::route('/{record}/edit'),
        ];
    }
}
