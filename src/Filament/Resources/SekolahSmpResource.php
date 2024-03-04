<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Kanekescom\Simgtk\Filament\Resources\SekolahSmpResource\Pages;
use Kanekescom\Simgtk\Models\Sekolah;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class SekolahSmpResource extends SekolahResource
{
    protected static ?string $slug = 'sekolah-smp';

    protected static ?string $pluralLabel = 'Sekolah SMP';

    protected static ?string $model = Sekolah::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'SMP';

    protected static ?string $navigationGroup = 'Sekolah';

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup('wilayah.nama')
            ->defaultSort('nama', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('#')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('nama')
                    ->wrap()
                    ->grow()
                    ->searchable()
                    ->sortable('nama')
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('npsn')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->label('NPSN'),
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
                Tables\Filters\SelectFilter::make('wilayah_id')
                    ->relationship('wilayah', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Wilayah'),
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
                        Column::make('npsn')
                            ->heading('NPSN'),
                        Column::make('status_kode')
                            ->heading('Status'),
                        Column::make('pegawai_aktif_count')
                            ->getStateUsing(fn ($record) => $record->pegawaiAktif()->count())
                            ->heading('Pegawai'),
                        Column::make('guru_aktif_count')
                            ->getStateUsing(fn ($record) => $record->guruAktif()->count())
                            ->heading('Guru'),
                    ])->withFilename(fn ($resource) => str($resource::getSlug())->replace('/', '_').'-'.now()->format('Y-m-d')),
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
            'index' => Pages\ListSekolahSmp::route('/'),
            'create' => Pages\CreateSekolahSmp::route('/create'),
            'edit' => Pages\EditSekolahSmp::route('/{record}/edit'),
        ];
    }
}
