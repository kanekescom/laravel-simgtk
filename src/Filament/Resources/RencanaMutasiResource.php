<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Kanekescom\Simgtk\Filament\Resources\RencanaMutasiResource\Pages;
use Kanekescom\Simgtk\Models\RencanaMutasi;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class RencanaMutasiResource extends Resource implements HasShieldPermissions
{
    protected static ?string $slug = 'referensi/mutasi/rencana-mutasi';

    protected static ?string $pluralLabel = 'Rencana Mutasi';

    protected static ?string $model = RencanaMutasi::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Rencana';

    protected static ?string $navigationGroup = 'Mutasi';

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
                Forms\Components\DatePicker::make('tanggal_mulai')
                    ->date()
                    ->required()
                    ->label('Tanggal Mulai'),
                Forms\Components\DatePicker::make('tanggal_berakhir')
                    ->afterOrEqual('tanggal_mulai')
                    ->required()
                    ->label('Tanggal Berakhir'),
                Forms\Components\Toggle::make('is_aktif')
                    ->label('Aktif'),
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
                    ->label('Aktif'),
                Tables\Columns\TextColumn::make('usul_count')
                    ->counts('usul')
                    ->alignEnd()
                    ->sortable()
                    ->label('Usulan'),
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
                Tables\Filters\TernaryFilter::make('is_aktif')
                    ->label('Aktif'),
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
                ExportBulkAction::make()->exports([
                    ExcelExport::make()->withColumns([
                        Column::make('nama')
                            ->heading('Nama'),
                        Column::make('tanggal_mulai')
                            ->heading('Mulai'),
                        Column::make('tanggal_berakhir')
                            ->heading('Berakhir'),
                        Column::make('is_aktif')
                            ->getStateUsing(fn ($record) => (int) $record->is_aktif)
                            ->heading('Aktif'),
                        Column::make('usul_count')
                            ->getStateUsing(fn ($record) => $record->usul()->count())
                            ->heading('Usulan'),
                        Column::make('pegawai_aktif_count')
                            ->getStateUsing(fn ($record) => $record->pegawaiAktif()->count())
                            ->heading('Pegawai'),
                        Column::make('guru_aktif_count')
                            ->getStateUsing(fn ($record) => $record->guruAktif()->count())
                            ->heading('Guru'),
                    ])->withFilename(fn ($resource) => str($resource::getSlug())->replace('/', '_').'-'.now()->format('Y-m-d')),
                ])->visible(auth()->user()->can('export_'.self::class)),
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
            'index' => Pages\ListRencanaMutasi::route('/'),
            'create' => Pages\CreateRencanaMutasi::route('/create'),
            'edit' => Pages\EditRencanaMutasi::route('/{record}/edit'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'restore',
            'restore_any',
            'replicate',
            'reorder',
            'delete',
            'delete_any',
            'force_delete',
            'force_delete_any',
            'import',
            'export',
        ];
    }
}
