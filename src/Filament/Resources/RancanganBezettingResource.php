<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kanekescom\Simgtk\Enums\StatusSekolahEnum;
use Kanekescom\Simgtk\Filament\Resources\RancanganBezettingResource\Pages;
use Kanekescom\Simgtk\Models\RancanganBezetting;
use Kanekescom\Simgtk\Models\RencanaBezetting;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class RancanganBezettingResource extends Resource implements HasShieldPermissions
{
    protected static ?string $slug = 'rancangan-bezetting';

    protected static ?string $pluralLabel = 'Bezetting';

    protected static ?string $model = RancanganBezetting::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Bezetting';

    protected static ?string $navigationGroup = null;

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

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return RencanaBezetting::periodeAktif()->exists();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup('wilayah.nama')
            ->defaultSort('nama', 'asc')
            ->columns(self::getTableColumns())
            ->filtersFormColumns(4)
            ->filters(self::getTableFilters())
            ->bulkActions([
                ExportBulkAction::make()->exports([
                    ExcelExport::make()->withColumns(self::getExportColumns())
                        ->withFilename(fn ($resource) => str($resource::getSlug())->replace('/', '_').'-'.now()->format('Y-m-d')),
                ])->visible(auth()->user()->can('export_'.self::class)),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRancanganBezetting::route('/'),
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
            ->searchable()
            ->sortable()
            ->label('Sekolah');
        $columns[] = Tables\Columns\TextColumn::make('status_kode')
            ->sortable()
            ->label('Status');

        $columns[] = ColumnGroup::make('group_data')
            ->columns([
                Tables\Columns\TextColumn::make('jumlah_kelas')
                    ->alignEnd()
                    ->sortable()
                    ->label('Kelas'),
                Tables\Columns\TextColumn::make('jumlah_rombel')
                    ->alignEnd()
                    ->sortable()
                    ->label('Rombel'),
                Tables\Columns\TextColumn::make('jumlah_siswa')
                    ->alignEnd()
                    ->searchable()
                    ->sortable()
                    ->label('Siswa'),
            ])
            ->alignment(Alignment::Center)
            ->label('Data');

        $columns[] = ColumnGroup::make('group_kepsek')
            ->columns([
                Tables\Columns\TextColumn::make('kepsek')
                    ->icon(fn (string $state): string => $state == 1 ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (string $state): string => $state == 1 ? 'success' : 'danger')
                    ->alignEnd()
                    ->sortable()
                    ->label('Def'),
                Tables\Columns\TextColumn::make('plt_kepsek')
                    ->icon(fn (string $state): string => $state == 1 ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (string $state): string => $state == 1 ? 'success' : 'danger')
                    ->alignEnd()
                    ->sortable()
                    ->label('Plt'),
                Tables\Columns\TextColumn::make('jabatan_kepsek')
                    ->icon(fn (string $state): string => $state == 1 ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (string $state): string => $state == 1 ? 'success' : 'danger')
                    ->alignEnd()
                    ->sortable()
                    ->label('Ket'),
            ])
            ->alignment(Alignment::Center)
            ->label('Kepala Sekolah');

        foreach (self::$jenjangMapels as $jenjang_sekolah => $mapels) {
            $columns[] = ColumnGroup::make("group_{$jenjang_sekolah}_formasi_existing")
                ->columns([
                    Tables\Columns\TextColumn::make("{$jenjang_sekolah}_formasi_existing_pns")
                        ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                        ->alignEnd()
                        ->label('PNS'),
                    Tables\Columns\TextColumn::make("{$jenjang_sekolah}_formasi_existing_pppk")
                        ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                        ->alignEnd()
                        ->label('PPPK'),
                    Tables\Columns\TextColumn::make("{$jenjang_sekolah}_formasi_existing_gtt")
                        ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                        ->alignEnd()
                        ->label('GTT'),
                    Tables\Columns\TextColumn::make("{$jenjang_sekolah}_formasi_existing_total")
                        ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                        ->alignEnd()
                        ->label('JML'),
                ])
                ->alignment(Alignment::Center)
                ->label('Existing');

            foreach ($mapels as $mapel) {
                $columns[] = ColumnGroup::make("group_{$jenjang_sekolah}_{$mapel}")
                    ->columns([
                        Tables\Columns\TextColumn::make("{$jenjang_sekolah}_{$mapel}_abk")
                            ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                            ->alignEnd()
                            ->badge()
                            ->color('info')
                            ->label('ABK'),
                        Tables\Columns\TextColumn::make("{$jenjang_sekolah}_{$mapel}_existing_pns")
                            ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                            ->alignEnd()
                            ->label('PNS'),
                        Tables\Columns\TextColumn::make("{$jenjang_sekolah}_{$mapel}_existing_pppk")
                            ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                            ->alignEnd()
                            ->label('PPPK'),
                        Tables\Columns\TextColumn::make("{$jenjang_sekolah}_{$mapel}_existing_gtt")
                            ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                            ->alignEnd()
                            ->label('GTT'),
                        Tables\Columns\TextColumn::make("{$jenjang_sekolah}_{$mapel}_existing_total")
                            ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                            ->alignEnd()
                            ->alignEnd()
                            ->badge()
                            ->label('Total'),
                        Tables\Columns\TextColumn::make("{$jenjang_sekolah}_{$mapel}_existing_selisih")
                            ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                            ->icon(fn (string $state): string => $state == 0 ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                            ->color(fn (string $state): string => $state == 0 ? 'success' : 'danger')
                            ->alignEnd()
                            ->label('+/-'),
                    ])
                    ->alignment(Alignment::Center)
                    ->label(self::$jenjangMapelHeaders[$jenjang_sekolah][$mapel]);
            }

            $columns[] = ColumnGroup::make("group_{$jenjang_sekolah}_jumlah")
                ->columns([
                    Tables\Columns\TextColumn::make("{$jenjang_sekolah}_formasi_abk")
                        ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                        ->icon(fn (string $state): string => $state == 0 ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                        ->color(fn (string $state): string => $state == 0 ? 'success' : 'danger')
                        ->alignEnd()
                        ->label('ABK'),
                    Tables\Columns\TextColumn::make("{$jenjang_sekolah}_formasi_existing_selisih")
                        ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                        ->icon(fn (string $state): string => $state == 0 ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                        ->color(fn (string $state): string => $state == 0 ? 'success' : 'danger')
                        ->alignEnd()
                        ->label('+/-'),
                ])
                ->alignment(Alignment::Center)
                ->label('Jumlah');
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
        $filters[] = Tables\Filters\SelectFilter::make('wilayah_id')
            ->relationship('wilayah', 'nama')
            ->searchable()
            ->preload()
            ->label('Wilayah');
        $filters[] = Tables\Filters\TernaryFilter::make('kepsek')
            ->queries(
                true: fn (Builder $query) => $query->where('kepsek', 1),
                false: fn (Builder $query) => $query->where('kepsek', '<>', 1),
                blank: fn (Builder $query) => $query,
            )
            ->trueLabel('Terisi')
            ->falseLabel('Kosong/Invalid')
            ->placeholder('All')
            ->native(false)
            ->label('Kepsek');
        $filters[] = Tables\Filters\TernaryFilter::make('plt_kepsek')
            ->queries(
                true: fn (Builder $query) => $query->where('kepsek', 1),
                false: fn (Builder $query) => $query->where('kepsek', '<>', 1),
                blank: fn (Builder $query) => $query,
            )
            ->trueLabel('Terisi')
            ->falseLabel('Kosong/Invalid')
            ->placeholder('All')
            ->native(false)
            ->label('Plt Kepsek');
        $filters[] = Tables\Filters\TernaryFilter::make('jabatan_kepsek')
            ->queries(
                true: fn (Builder $query) => $query->where(function (Builder $query) {
                    return $query->where('jabatan_kepsek', 1);
                }),
                false: fn (Builder $query) => $query->where(function (Builder $query) {
                    return $query->where('jabatan_kepsek', '<>', 1);
                }),
                blank: fn (Builder $query) => $query,
            )
            ->trueLabel('Terisi')
            ->falseLabel('Kosong/Invalid')
            ->placeholder('All')
            ->native(false)
            ->label('Jabatan Kepsek');

        foreach (self::$jenjangMapels as $jenjang_sekolah => $mapels) {
            foreach ($mapels as $mapel) {
                $filters[] = Tables\Filters\TernaryFilter::make("{$jenjang_sekolah}_{$mapel}_existing_terpenuhi")
                    ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                    ->queries(
                        true: fn (Builder $query) => $query->where(function (Builder $query) use ($jenjang_sekolah, $mapel) {
                            return $query->where("{$jenjang_sekolah}_{$mapel}_existing_selisih", 0);
                        }),
                        false: fn (Builder $query) => $query->where(function (Builder $query) use ($jenjang_sekolah, $mapel) {
                            return $query->where("{$jenjang_sekolah}_{$mapel}_existing_selisih", '<>', 0);
                        }),
                        blank: fn (Builder $query) => $query,
                    )
                    ->trueLabel('Terpenuhi')
                    ->falseLabel('Kurang/Lebih')
                    ->placeholder('All')
                    ->native(false)
                    ->label(self::$jenjangMapelHeaders[$jenjang_sekolah][$mapel].' Terpenuhi');

                $filters[] = Tables\Filters\TernaryFilter::make("{$jenjang_sekolah}_{$mapel}_existing_lebih_kurang")
                    ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                    ->queries(
                        true: fn (Builder $query) => $query->where(function (Builder $query) use ($jenjang_sekolah, $mapel) {
                            return $query->where("{$jenjang_sekolah}_{$mapel}_existing_selisih", '<', 0);
                        }),
                        false: fn (Builder $query) => $query->where(function (Builder $query) use ($jenjang_sekolah, $mapel) {
                            return $query->where("{$jenjang_sekolah}_{$mapel}_existing_selisih", '>', 0);
                        }),
                        blank: fn (Builder $query) => $query,
                    )
                    ->trueLabel('Kurang')
                    ->falseLabel('Lebih')
                    ->placeholder('All')
                    ->native(false)
                    ->label(self::$jenjangMapelHeaders[$jenjang_sekolah][$mapel].' +/-');
            }

            $filters[] = Tables\Filters\TernaryFilter::make("{$jenjang_sekolah}_existing_terpenuhi")
                ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                ->queries(
                    true: fn (Builder $query) => $query->where(function (Builder $query) use ($jenjang_sekolah) {
                        return $query->where("{$jenjang_sekolah}_formasi_existing_selisih", 0);
                    }),
                    false: fn (Builder $query) => $query->where(function (Builder $query) use ($jenjang_sekolah) {
                        return $query->where("{$jenjang_sekolah}_formasi_existing_selisih", '<>', 0);
                    }),
                    blank: fn (Builder $query) => $query,
                )
                ->trueLabel('Terpenuhi')
                ->falseLabel('Kurang/Lebih')
                ->placeholder('All')
                ->native(false)
                ->label('JML Terpenuhi');

            $filters[] = Tables\Filters\TernaryFilter::make("{$jenjang_sekolah}_existing_lebih_kurang")
                ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                ->queries(
                    true: fn (Builder $query) => $query->where(function (Builder $query) use ($jenjang_sekolah) {
                        return $query->where("{$jenjang_sekolah}_formasi_existing_selisih", '<', 0);
                    }),
                    false: fn (Builder $query) => $query->where(function (Builder $query) use ($jenjang_sekolah) {
                        return $query->where("{$jenjang_sekolah}_formasi_existing_selisih", '>', 0);
                    }),
                    blank: fn (Builder $query) => $query,
                )
                ->trueLabel('Kurang')
                ->falseLabel('Lebih')
                ->placeholder('All')
                ->native(false)
                ->label('JML +/-');
        }

        return $filters;
    }

    public static function getExportColumns(): array
    {
        $columns = [];
        $columns[] = Column::make('nama')
            ->heading('Sekolah');
        $columns[] = Column::make('status_kode')
            ->heading('Status');
        $columns[] = Column::make('jumlah_kelas')
            ->heading('Kelas');
        $columns[] = Column::make('jumlah_rombel')
            ->heading('Rombel');
        $columns[] = Column::make('jumlah_siswa')
            ->heading('Siswa');
        $columns[] = Column::make('kepsek')
            ->heading('Def');
        $columns[] = Column::make('plt_kepsek')
            ->heading('Plt');
        $columns[] = Column::make('jabatan_kepsek')
            ->heading('Ket');

        foreach (self::$jenjangMapels as $jenjang_sekolah => $mapels) {
            $columns[] = Column::make("{$jenjang_sekolah}_formasi_existing_pns")
                ->heading('PNS');
            $columns[] = Column::make("{$jenjang_sekolah}_formasi_existing_pppk")
                ->heading('PPPK');
            $columns[] = Column::make("{$jenjang_sekolah}_formasi_existing_gtt")
                ->heading('GTT');
            $columns[] = Column::make("{$jenjang_sekolah}_formasi_existing_total")
                ->heading('JML');

            foreach ($mapels as $mapel) {
                $columns[] = Column::make("{$jenjang_sekolah}_{$mapel}_abk")
                    ->heading('ABK');
                $columns[] = Column::make("{$jenjang_sekolah}_{$mapel}_existing_pns")
                    ->heading('PNS');
                $columns[] = Column::make("{$jenjang_sekolah}_{$mapel}_existing_pppk")
                    ->heading('PPPK');
                $columns[] = Column::make("{$jenjang_sekolah}_{$mapel}_existing_gtt")
                    ->heading('GTT');
                $columns[] = Column::make("{$jenjang_sekolah}_{$mapel}_existing_total")
                    ->heading('Total');
                $columns[] = Column::make("{$jenjang_sekolah}_{$mapel}_existing_selisih")
                    ->heading('+/-');
            }

            $columns[] = Column::make("{$jenjang_sekolah}_formasi_abk")
                ->heading('ABK');
            $columns[] = Column::make("{$jenjang_sekolah}_formasi_existing_selisih")
                ->heading('+/-');
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
