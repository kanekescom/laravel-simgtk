<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Kanekescom\Simgtk\Filament\Resources\RancanganBezzetingResource\Pages;
use Kanekescom\Simgtk\Models\RancanganBezzeting;
use Kanekescom\Simgtk\Models\RencanaBezzeting;

class RancanganBezzetingResource extends Resource
{
    protected static ?string $slug = 'rancangan-bezzeting';

    protected static ?string $pluralLabel = 'Bezzeting';

    protected static ?string $model = RancanganBezzeting::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Bezzeting';

    protected static ?string $navigationGroup = null;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return RencanaBezzeting::periodeAktif()->exists();
    }

    public static function table(Table $table): Table
    {
        $columns = [];
        $columns[] = Tables\Columns\TextColumn::make('sekolah.nama')
            ->wrap()
            ->searchable()
            ->sortable()
            ->label('Sekolah');

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
            ->rules(['required', 'digits_between:0,100'])
            ->searchable()
            ->sortable()
            ->label('Siswa');

        $columns[] = Tables\Columns\TextColumn::make('pegawai_kepsek_count')
            ->counts('pegawaiKepsek')
            ->icon(fn (string $state): string => $state == 1 ? 'heroicon-o-check' : 'heroicon-o-x-mark')
            ->color(fn (string $state): string => $state == 1 ? 'success' : 'danger')
            ->sortable()
            ->label('Kepsek');
        $columns[] = Tables\Columns\TextColumn::make('pegawai_plt_kepsek_count')
            ->counts('pegawaiPltKepsek')
            ->icon(fn (string $state, Model $record): string => $state == 1 && $record->pegawaiKepsek()->count() == 0 ? 'heroicon-o-check' : 'heroicon-o-x-mark')
            ->color(fn (string $state, Model $record): string => $state == 1 && $record->pegawaiKepsek()->count() == 0 ? 'success' : 'danger')
            ->sortable()
            ->label('Plt');

        $jenjang_mapel_headers = [
            'sd' => [
                'kelas' => 'KLS',
                'penjaskes' => 'PJK',
                'agama' => 'AGM',
                'agama_noni' => 'AGM NI',
            ],
            'smp' => [
                'pai' => 'PAI',
                'pjok' => 'PJOK',
                'b_indonesia' => 'BIND',
                'b_inggris' => 'BING',
                'bk' => 'BK',
                'ipa' => 'IPA',
                'ips' => 'IPS',
                'matematika' => 'MTK',
                'ppkn' => 'PPKN',
                'prakarya' => 'PKY',
                'seni_budaya' => 'SEBUD',
                'b_sunda' => 'BSUN',
                'tik' => 'TIK',
            ],
        ];

        $jenjang_mapels = [
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

        foreach ($jenjang_mapels as $jenjang_sekolah => $mapels) {
            $columns[] = Tables\Columns\TextColumn::make("pegawai_{$jenjang_sekolah}_status_kepegawaian_pns_count")
                ->counts('pegawai' . str($jenjang_sekolah)->ucfirst() . 'StatusKepegawaianPns')
                ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                ->label('PNS');
            $columns[] = Tables\Columns\TextColumn::make("pegawai_{$jenjang_sekolah}_status_kepegawaian_pppk_count")
                ->counts('pegawai' . str($jenjang_sekolah)->ucfirst() . 'StatusKepegawaianPppk')
                ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                ->label('PPPK');
            $columns[] = Tables\Columns\TextColumn::make("pegawai_{$jenjang_sekolah}_status_kepegawaian_gtt_count")
                ->counts('pegawai' . str($jenjang_sekolah)->ucfirst() . 'StatusKepegawaianGtt')
                ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                ->label('GTT');
            $columns[] = Tables\Columns\TextColumn::make("pegawai_{$jenjang_sekolah}_count")
                ->counts('pegawai' . str($jenjang_sekolah)->ucfirst())
                ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                ->label('JML');

            foreach ($mapels as $mapel) {
                $field_jenjang_sekolah_mapel_abk = "{$jenjang_sekolah}_{$mapel}_abk";
                $field_jenjang_sekolah_mapel_pns = "{$jenjang_sekolah}_{$mapel}_pns";
                $field_jenjang_sekolah_mapel_pppk = "{$jenjang_sekolah}_{$mapel}_pppk";
                $field_jenjang_sekolah_mapel_gtt = "{$jenjang_sekolah}_{$mapel}_gtt";
                $field_jenjang_sekolah_mapel_total = "{$jenjang_sekolah}_{$mapel}_total";
                $field_jenjang_sekolah_mapel_selisih = "{$jenjang_sekolah}_{$mapel}_selisih";

                $field_jenjang_sekolah_mapel_existing_pns = "{$jenjang_sekolah}_{$mapel}_existing_pns";
                $field_jenjang_sekolah_mapel_existing_pppk = "{$jenjang_sekolah}_{$mapel}_existing_pppk";
                $field_jenjang_sekolah_mapel_existing_gtt = "{$jenjang_sekolah}_{$mapel}_existing_gtt";
                $field_jenjang_sekolah_mapel_existing_total = "{$jenjang_sekolah}_{$mapel}_existing_total";
                $field_jenjang_sekolah_mapel_existing_selisih = "{$jenjang_sekolah}_{$mapel}_existing_selisih";

                $columns[] = Tables\Columns\TextInputColumn::make($field_jenjang_sekolah_mapel_abk)
                    ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                    ->rules(['required', 'digits_between:0,100'])
                    ->label("{$jenjang_mapel_headers[$jenjang_sekolah][$mapel]} ABK");
                $columns[] = Tables\Columns\TextInputColumn::make($field_jenjang_sekolah_mapel_pns)
                    ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                    ->rules(['required', 'digits_between:0,100'])
                    ->label("{$jenjang_mapel_headers[$jenjang_sekolah][$mapel]} PNS");
                $columns[] = Tables\Columns\TextInputColumn::make($field_jenjang_sekolah_mapel_pppk)
                    ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                    ->rules(['required', 'digits_between:0,100'])
                    ->label("{$jenjang_mapel_headers[$jenjang_sekolah][$mapel]} PPPK");
                $columns[] = Tables\Columns\TextInputColumn::make($field_jenjang_sekolah_mapel_gtt)
                    ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                    ->rules(['required', 'digits_between:0,100'])
                    ->label("{$jenjang_mapel_headers[$jenjang_sekolah][$mapel]} GTT");
                $columns[] = Tables\Columns\TextColumn::make($field_jenjang_sekolah_mapel_total)
                    ->icon(fn (Model $record): string => $record->$field_jenjang_sekolah_mapel_abk == $record->$field_jenjang_sekolah_mapel_total ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->$field_jenjang_sekolah_mapel_abk == $record->$field_jenjang_sekolah_mapel_total ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                    ->label('ABK');
                $columns[] = Tables\Columns\TextColumn::make($field_jenjang_sekolah_mapel_selisih)
                    ->icon(fn (Model $record): string => $record->$field_jenjang_sekolah_mapel_selisih == 0 ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->$field_jenjang_sekolah_mapel_selisih == 0 ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                    ->label('+/- ABK');
                $columns[] = Tables\Columns\TextColumn::make($field_jenjang_sekolah_mapel_existing_total)
                    ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                    ->label('EXT');
                $columns[] = Tables\Columns\TextColumn::make($field_jenjang_sekolah_mapel_existing_selisih)
                    ->icon(fn (Model $record): string => $record->$field_jenjang_sekolah_mapel_existing_selisih == 0 ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->$field_jenjang_sekolah_mapel_existing_selisih == 0 ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                    ->label('+/- EXT');
            }

            $field_jenjang_sekolah_formasi_abk = "{$jenjang_sekolah}_formasi_abk";
            $field_jenjang_sekolah_formasi_pns = "{$jenjang_sekolah}_formasi_pns";
            $field_jenjang_sekolah_formasi_pppk = "{$jenjang_sekolah}_formasi_pppk";
            $field_jenjang_sekolah_formasi_gtt = "{$jenjang_sekolah}_formasi_gtt";
            $field_jenjang_sekolah_formasi_total = "{$jenjang_sekolah}_formasi_total";
            $field_jenjang_sekolah_formasi_selisih = "{$jenjang_sekolah}_formasi_selisih";

            $field_jenjang_sekolah_formasi_existing_pns = "{$jenjang_sekolah}_formasi_existing_pns";
            $field_jenjang_sekolah_formasi_existing_pppk = "{$jenjang_sekolah}_formasi_existing_pppk";
            $field_jenjang_sekolah_formasi_existing_gtt = "{$jenjang_sekolah}_formasi_existing_gtt";
            $field_jenjang_sekolah_formasi_existing_total = "{$jenjang_sekolah}_formasi_existing_total";
            $field_jenjang_sekolah_formasi_existing_selisih = "{$jenjang_sekolah}_formasi_existing_selisih";

            $columns[] = Tables\Columns\TextColumn::make($field_jenjang_sekolah_formasi_abk)
                ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                ->label('JML ABK');
            $columns[] = Tables\Columns\TextColumn::make($field_jenjang_sekolah_formasi_selisih)
                ->icon(fn (Model $record): string => $record->$field_jenjang_sekolah_formasi_selisih == 0 ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                ->color(fn (Model $record): string => $record->$field_jenjang_sekolah_formasi_selisih == 0 ? 'success' : 'danger')
                ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                ->label('+/- ABK');
            $columns[] = Tables\Columns\TextColumn::make($field_jenjang_sekolah_formasi_existing_total)
                ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                ->label('JML EXT');
            $columns[] = Tables\Columns\TextColumn::make($field_jenjang_sekolah_formasi_existing_selisih)
                ->icon(fn (Model $record): string => $record->$field_jenjang_sekolah_formasi_existing_selisih == 0 ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                ->color(fn (Model $record): string => $record->$field_jenjang_sekolah_formasi_existing_selisih == 0 ? 'success' : 'danger')
                ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                ->label('+/- EXT');
        }

        return $table
            ->defaultGroup('wilayah.nama')
            ->columns($columns)
            ->filtersFormColumns(2)
            ->filters([
                Tables\Filters\TernaryFilter::make('pegawai_kepsek_count')
                    ->trueLabel('Terisi')
                    ->falseLabel('Kosong/Invalid')
                    ->queries(
                        true: fn (Builder $query) => $query->whereHas('pegawaiKepsek', function (Builder $query) {
                            $query;
                        }, 1),
                        false: fn (Builder $query) => $query->whereHas('pegawaiKepsek', function (Builder $query) {
                            $query;
                        }, '<>', 1),
                        blank: fn (Builder $query) => $query,
                    )
                    ->placeholder('All')
                    ->native(false)
                    ->label('Kepsek'),
                Tables\Filters\TernaryFilter::make('pegawai_plt_kepsek_count')
                    ->trueLabel('Terisi')
                    ->falseLabel('Kosong/Invalid')
                    ->queries(
                        true: fn (Builder $query) => $query->whereHas('pegawaiPltKepsek', function (Builder $query) {
                            $query;
                        }, 1),
                        false: fn (Builder $query) => $query->whereHas('pegawaiPltKepsek', function (Builder $query) {
                            $query;
                        }, '<>', 1),
                        blank: fn (Builder $query) => $query,
                    )
                    ->placeholder('All')
                    ->native(false)
                    ->label('Plt Kepsek'),

                Tables\Filters\SelectFilter::make('wilayah_id')
                    ->relationship('wilayah', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Wilayah'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRancanganBezzeting::route('/'),
        ];
    }
}
