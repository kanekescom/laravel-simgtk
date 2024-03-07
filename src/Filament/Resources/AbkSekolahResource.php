<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Kanekescom\Simgtk\Enums\StatusSekolahEnum;
use Kanekescom\Simgtk\Filament\Resources\AbkSekolahResource\Pages;
use Kanekescom\Simgtk\Models\AbkSekolah;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class AbkSekolahResource extends Resource implements HasShieldPermissions
{
    protected static ?string $slug = 'referensi/bezetting/abk-sekolah';

    protected static ?string $pluralLabel = 'ABK Sekolah';

    protected static ?string $model = AbkSekolah::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'ABK';

    protected static ?string $navigationGroup = 'Referensi Bezetting';

    protected static array $jenjangMapelHeaders = [
        'sd' => [
            'kelas' => 'KELAS',
            'penjaskes' => 'PENJASKES',
            'agama' => 'AGAMA',
            'agama_noni' => 'AGAMA NONI',
        ],
        'smp' => [
            'pai' => 'PAI',
            'pjok' => 'PJOK',
            'b_indonesia' => 'B. INDONESIA',
            'b_inggris' => 'B. INGGRIS',
            'bk' => 'BK',
            'ipa' => 'IPA',
            'ips' => 'IPS',
            'matematika' => 'MATEMATIKA',
            'ppkn' => 'PPKN',
            'prakarya' => 'PRAKARYA',
            'seni_budaya' => 'SENI BUDAYA',
            'b_sunda' => 'B. SUNDA',
            'tik' => 'TIK',
        ],
    ];

    protected static array $jenjangMapels = [
        'sd' => [
            'kelas',
            'penjaskes',
            'agama',
            'agama_noni',
        ],
        'smp' => [
            'pai',
            'pjok',
            'b_indonesia',
            'b_inggris',
            'bk',
            'ipa',
            'ips',
            'matematika',
            'ppkn',
            'prakarya',
            'seni_budaya',
            'b_sunda',
            'tik',
        ],
    ];

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup('wilayah.nama')
            ->defaultSort('nama', 'asc')
            ->columns(self::getTableColumns())
            ->filters(self::getTableFilters())
            ->filters([
                Tables\Filters\SelectFilter::make('status_kode')
                    ->options(StatusSekolahEnum::class)
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->label('Status'),
                Tables\Filters\SelectFilter::make('jenjang_sekolah')
                    ->relationship('jenjangSekolah', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Jenjang Sekolah'),
                Tables\Filters\SelectFilter::make('wilayah_id')
                    ->relationship('wilayah', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Wilayah'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                ExportBulkAction::make()->exports([
                    ExcelExport::make()->withColumns(self::getExportColumns())
                        ->withFilename(fn ($resource) => str($resource::getSlug())->replace('/', '_').'-'.now()->format('Y-m-d')),
                ])->visible(auth()->user()->can('export_'.self::class)),
            ])
            ->emptyStateActions([
                //
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
            'index' => Pages\ListAbkSekolah::route('/'),
        ];
    }

    public static function getTableColumns(): array
    {
        $columns = [];
        $columns[] = Tables\Columns\TextColumn::make('#')
            ->rowIndex();
        $columns[] = Tables\Columns\TextColumn::make('nama')
            ->wrap()
            ->grow()
            ->searchable(['nama', 'npsn'])
            ->sortable('nama')
            ->label('Nama');
        $columns[] = Tables\Columns\TextColumn::make('status_kode')
            ->sortable()
            ->label('Status');
        $columns[] = Tables\Columns\TextInputColumn::make('jumlah_kelas')
            ->rules(['required', 'digits_between:0,100'])
            ->searchable()
            ->sortable()
            ->label('Kelas');
        $columns[] = Tables\Columns\TextInputColumn::make('jumlah_rombel')
            ->rules(['required', 'digits_between:0,100'])
            ->searchable()
            ->sortable()
            ->label('Rombel');
        $columns[] = Tables\Columns\TextInputColumn::make('jumlah_siswa')
            ->rules(['required', 'digits_between:0,10000'])
            ->searchable()
            ->sortable()
            ->label('Siswa');

        foreach (self::$jenjangMapels as $jenjang_sekolah => $mapels) {
            foreach ($mapels as $mapel) {
                $columns[] = Tables\Columns\TextInputColumn::make("{$jenjang_sekolah}_{$mapel}_abk")
                    ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                    ->rules(['required', 'digits_between:0,10000'])
                    ->searchable()
                    ->sortable()
                    ->label(self::$jenjangMapelHeaders[$jenjang_sekolah][$mapel]);
            }

            $columns[] = Tables\Columns\TextColumn::make("{$jenjang_sekolah}_formasi_abk")
                ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                ->alignEnd()
                ->searchable()
                ->sortable()
                ->label('JML');
        }

        return $columns;
    }

    public static function getTableFilters(): array
    {
        $filters = [];
        $filters[] = Tables\Filters\SelectFilter::make('status_kode')
            ->options(StatusSekolahEnum::class)
            ->multiple()
            ->searchable()
            ->preload()
            ->label('Status');
        $filters[] = Tables\Filters\SelectFilter::make('jenjang_sekolah')
            ->relationship('jenjangSekolah', 'nama')
            ->searchable()
            ->preload()
            ->label('Jenjang Sekolah');
        $filters[] = Tables\Filters\SelectFilter::make('wilayah_id')
            ->relationship('wilayah', 'nama')
            ->searchable()
            ->preload()
            ->label('Wilayah');
        $filters[] = Tables\Filters\TrashedFilter::make();

        return $filters;
    }

    public static function getExportColumns(): array
    {
        $columns = [];
        $columns[] = Column::make('nama')
            ->heading('Nama');
        $columns[] = Column::make('status_kode')
            ->heading('Status');
        $columns[] = Column::make('jumlah_kelas')
            ->heading('Kelas');
        $columns[] = Column::make('jumlah_rombel')
            ->heading('Rombel');
        $columns[] = Column::make('jumlah_siswa')
            ->heading('Siswa');

        foreach (self::$jenjangMapels as $jenjang_sekolah => $mapels) {
            foreach ($mapels as $mapel) {
                $columns[] = Column::make("{$jenjang_sekolah}_{$mapel}_abk")
                    ->heading(self::$jenjangMapelHeaders[$jenjang_sekolah][$mapel]);
            }

            $columns[] = Column::make("{$jenjang_sekolah}_formasi_abk")
                ->heading('JML');
        }

        return $columns;
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
