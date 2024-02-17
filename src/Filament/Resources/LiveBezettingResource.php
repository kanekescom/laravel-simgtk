<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Kanekescom\Simgtk\Filament\Resources\LiveBezettingResource\Pages;
use Kanekescom\Simgtk\Models\Sekolah;

class LiveBezettingResource extends Resource
{
    protected static ?string $slug = 'live-bezetting';

    protected static ?string $pluralLabel = 'Live Bezetting';

    protected static ?string $model = Sekolah::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Live Bezetting';

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

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup('wilayah.nama')
            ->defaultSort('nama', 'asc')
            ->columns(self::getTableColumns())
            ->filtersFormColumns(4)
            ->filters(self::getTableFilters());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLiveBezettingBezetting::route('/'),
        ];
    }

    public static function getTableColumns(): array
    {
        $columns = [];
        $columns[] = Tables\Columns\TextColumn::make('index')
            ->rowIndex()
            ->label('#');
        $columns[] = Tables\Columns\TextColumn::make('nama')
            ->wrap()
            ->grow()
            ->searchable()
            ->sortable()
            ->label('Sekolah');

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
                Tables\Columns\TextColumn::make('pegawai_kepsek_count')
                    ->counts('pegawaiKepsek')
                    ->icon(fn (string $state): string => $state == 1 ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (string $state): string => $state == 1 ? 'success' : 'danger')
                    ->alignEnd()
                    ->sortable()
                    ->label('Def'),
                Tables\Columns\TextColumn::make('pegawai_plt_kepsek_count')
                    ->counts('pegawaiPltKepsek')
                    ->icon(fn (string $state): string => $state == 1 ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (string $state): string => $state == 1 ? 'success' : 'danger')
                    ->alignEnd()
                    ->sortable()
                    ->label('Plt'),
                Tables\Columns\TextColumn::make('pegawai_jabatan_kepsek_count')
                    ->counts('pegawaiJabatanKepsek')
                    ->icon(fn (string $state): string => $state == 1 ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (string $state): string => $state == 1 ? 'success' : 'danger')
                    ->alignEnd()
                    ->sortable()
                    ->label('Ket'),
            ])
            ->alignment(Alignment::Center)
            ->label('Kepala Sekolah');

        foreach (self::$jenjangMapels as $jenjang_sekolah => $mapels) {
            $jenjang_sekolah_studly = str($jenjang_sekolah)->studly();

            $columns[] = ColumnGroup::make("group_{$jenjang_sekolah}_formasi_existing")
                ->columns([
                    Tables\Columns\TextColumn::make("pegawai_{$jenjang_sekolah}_status_kepegawaian_pns_count")
                        ->counts("pegawai{$jenjang_sekolah_studly}StatusKepegawaianPns")
                        ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                        ->alignEnd()
                        ->sortable()
                        ->label('PNS'),
                    Tables\Columns\TextColumn::make("pegawai_{$jenjang_sekolah}_status_kepegawaian_pppk_count")
                        ->counts("pegawai{$jenjang_sekolah_studly}StatusKepegawaianPppk")
                        ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                        ->alignEnd()
                        ->sortable()
                        ->label('PPPK'),
                    Tables\Columns\TextColumn::make("pegawai_{$jenjang_sekolah}_status_kepegawaian_gtt_count")
                        ->counts("pegawai{$jenjang_sekolah_studly}StatusKepegawaianGtt")
                        ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                        ->alignEnd()
                        ->sortable()
                        ->label('GTT'),
                    Tables\Columns\TextColumn::make("pegawai_{$jenjang_sekolah}_count")
                        ->counts("pegawai{$jenjang_sekolah_studly}")
                        ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                        ->alignEnd()
                        ->sortable()
                        ->label('JML'),
                ])
                ->alignment(Alignment::Center)
                ->label('Existing');

            foreach ($mapels as $mapel) {
                $mapel_studly = str($mapel)->studly();

                $columns[] = ColumnGroup::make("group_{$jenjang_sekolah}_{$mapel}")
                    ->columns([
                        Tables\Columns\TextColumn::make("{$jenjang_sekolah}_{$mapel}_abk")
                            ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                            ->alignEnd()
                            ->badge()
                            ->color('info')
                            ->sortable()
                            ->label('ABK'),
                        Tables\Columns\TextColumn::make("pegawai_{$jenjang_sekolah}_{$mapel}_status_kepegawaian_pns_count")
                            ->counts("pegawai{$jenjang_sekolah_studly}{$mapel_studly}StatusKepegawaianPns")
                            ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                            ->alignEnd()
                            ->sortable()
                            ->sortable()
                            ->label('PNS'),
                        Tables\Columns\TextColumn::make("pegawai_{$jenjang_sekolah}_{$mapel}_status_kepegawaian_pppk_count")
                            ->counts("pegawai{$jenjang_sekolah_studly}{$mapel_studly}StatusKepegawaianPppk")
                            ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                            ->alignEnd()
                            ->sortable()
                            ->label('PPPK'),
                        Tables\Columns\TextColumn::make("pegawai_{$jenjang_sekolah}_{$mapel}_status_kepegawaian_gtt_count")
                            ->counts("pegawai{$jenjang_sekolah_studly}{$mapel_studly}StatusKepegawaianGtt")
                            ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                            ->alignEnd()
                            ->sortable()
                            ->label('GTT'),
                        Tables\Columns\TextColumn::make("pegawai_{$jenjang_sekolah}_{$mapel}_count")
                            ->counts("pegawai{$jenjang_sekolah_studly}{$mapel_studly}")
                            ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                            ->alignEnd()
                            ->badge()
                            ->color('warning')
                            ->sortable()
                            ->label('Total'),
                        Tables\Columns\TextColumn::make("pegawai_{$jenjang_sekolah}_{$mapel}_selisih")
                            ->state(
                                static function (Model $record) use ($jenjang_sekolah, $mapel): int {
                                    return (int) ($record->{"pegawai_{$jenjang_sekolah}_{$mapel}_count"} - $record->{"{$jenjang_sekolah}_{$mapel}_abk"});
                                }
                            )
                            ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                            ->icon(fn (string $state): string => $state == 0 ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                            ->color(fn (string $state): string => $state == 0 ? 'success' : 'danger')
                            ->alignEnd()
                            ->sortable()
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
                        ->sortable()
                        ->label('ABK'),
                    Tables\Columns\TextColumn::make("{$jenjang_sekolah}_formasi_existing_selisih")
                        ->state(
                            static function (Model $record) use ($jenjang_sekolah): int {
                                return (int) ($record->{"pegawai_{$jenjang_sekolah}_count"} - $record->{"{$jenjang_sekolah}_formasi_abk"});
                            }
                        )
                        ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                        ->icon(fn (string $state): string => $state == 0 ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                        ->color(fn (string $state): string => $state == 0 ? 'success' : 'danger')
                        ->alignEnd()
                        ->sortable()
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
        // $filters[] = Tables\Filters\SelectFilter::make('wilayah_id')
        //     ->relationship('wilayah', 'nama')
        //     ->searchable()
        //     ->preload()
        //     ->label('Wilayah');
        // $filters[] = Tables\Filters\TernaryFilter::make('kepsek')
        //     ->queries(
        //         true: fn (Builder $query) => $query->where('kepsek', 1),
        //         false: fn (Builder $query) => $query->where('kepsek', '<>', 1),
        //         blank: fn (Builder $query) => $query,
        //     )
        //     ->trueLabel('Terisi')
        //     ->falseLabel('Kosong/Invalid')
        //     ->placeholder('All')
        //     ->native(false)
        //     ->label('Kepsek');
        // $filters[] = Tables\Filters\TernaryFilter::make('plt_kepsek')
        //     ->queries(
        //         true: fn (Builder $query) => $query->where('kepsek', 1),
        //         false: fn (Builder $query) => $query->where('kepsek', '<>', 1),
        //         blank: fn (Builder $query) => $query,
        //     )
        //     ->trueLabel('Terisi')
        //     ->falseLabel('Kosong/Invalid')
        //     ->placeholder('All')
        //     ->native(false)
        //     ->label('Plt Kepsek');
        // $filters[] = Tables\Filters\TernaryFilter::make('jabatan_kepsek')
        //     ->queries(
        //         true: fn (Builder $query) => $query->where(function (Builder $query) {
        //             return $query->where('jabatan_kepsek', 1);
        //         }),
        //         false: fn (Builder $query) => $query->where(function (Builder $query) {
        //             return $query->where('jabatan_kepsek', '<>', 1);
        //         }),
        //         blank: fn (Builder $query) => $query,
        //     )
        //     ->trueLabel('Terisi')
        //     ->falseLabel('Kosong/Invalid')
        //     ->placeholder('All')
        //     ->native(false)
        //     ->label('Jabatan Kepsek');

        // foreach (self::$jenjangMapels as $jenjang_sekolah => $mapels) {
        //     foreach ($mapels as $mapel) {
        //         $filters[] = Tables\Filters\TernaryFilter::make("{$jenjang_sekolah}_{$mapel}_existing_terpenuhi")
        //             ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
        //             ->queries(
        //                 true: fn (Builder $query) => $query->where(function (Builder $query) use ($jenjang_sekolah, $mapel) {
        //                     return $query->where("{$jenjang_sekolah}_{$mapel}_existing_selisih", 0);
        //                 }),
        //                 false: fn (Builder $query) => $query->where(function (Builder $query) use ($jenjang_sekolah, $mapel) {
        //                     return $query->where("{$jenjang_sekolah}_{$mapel}_existing_selisih", '<>', 0);
        //                 }),
        //                 blank: fn (Builder $query) => $query,
        //             )
        //             ->trueLabel('Terpenuhi')
        //             ->falseLabel('Kurang/Lebih')
        //             ->placeholder('All')
        //             ->native(false)
        //             ->label(self::$jenjangMapelHeaders[$jenjang_sekolah][$mapel] . ' Terpenuhi');

        //         $filters[] = Tables\Filters\TernaryFilter::make("{$jenjang_sekolah}_{$mapel}_existing_lebih_kurang")
        //             ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
        //             ->queries(
        //                 true: fn (Builder $query) => $query->where(function (Builder $query) use ($jenjang_sekolah, $mapel) {
        //                     return $query->where("{$jenjang_sekolah}_{$mapel}_existing_selisih", '<', 0);
        //                 }),
        //                 false: fn (Builder $query) => $query->where(function (Builder $query) use ($jenjang_sekolah, $mapel) {
        //                     return $query->where("{$jenjang_sekolah}_{$mapel}_existing_selisih", '>', 0);
        //                 }),
        //                 blank: fn (Builder $query) => $query,
        //             )
        //             ->trueLabel('Kurang')
        //             ->falseLabel('Lebih')
        //             ->placeholder('All')
        //             ->native(false)
        //             ->label(self::$jenjangMapelHeaders[$jenjang_sekolah][$mapel] . ' +/-');
        //     }

        //     $filters[] = Tables\Filters\TernaryFilter::make("{$jenjang_sekolah}_existing_terpenuhi")
        //         ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
        //         ->queries(
        //             true: fn (Builder $query) => $query->where(function (Builder $query) use ($jenjang_sekolah, $mapel) {
        //                 return $query->where("{$jenjang_sekolah}_formasi_existing_selisih", 0);
        //             }),
        //             false: fn (Builder $query) => $query->where(function (Builder $query) use ($jenjang_sekolah, $mapel) {
        //                 return $query->where("{$jenjang_sekolah}_formasi_existing_selisih", '<>', 0);
        //             }),
        //             blank: fn (Builder $query) => $query,
        //         )
        //         ->trueLabel('Terpenuhi')
        //         ->falseLabel('Kurang/Lebih')
        //         ->placeholder('All')
        //         ->native(false)
        //         ->label("JML Terpenuhi");

        //     $filters[] = Tables\Filters\TernaryFilter::make("{$jenjang_sekolah}_existing_lebih_kurang")
        //         ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
        //         ->queries(
        //             true: fn (Builder $query) => $query->where(function (Builder $query) use ($jenjang_sekolah, $mapel) {
        //                 return $query->where("{$jenjang_sekolah}_formasi_existing_selisih", '<', 0);
        //             }),
        //             false: fn (Builder $query) => $query->where(function (Builder $query) use ($jenjang_sekolah, $mapel) {
        //                 return $query->where("{$jenjang_sekolah}_formasi_existing_selisih", '>', 0);
        //             }),
        //             blank: fn (Builder $query) => $query,
        //         )
        //         ->trueLabel('Kurang')
        //         ->falseLabel('Lebih')
        //         ->placeholder('All')
        //         ->native(false)
        //         ->label("JML +/-");
        // }

        return $filters;
    }
}
