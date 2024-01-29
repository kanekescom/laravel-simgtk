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
        return $table
            ->defaultGroup('wilayah.nama')
            ->columns([
                Tables\Columns\TextColumn::make('sekolah.nama')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->label('Sekolah'),

                Tables\Columns\TextInputColumn::make('jumlah_kelas')
                    ->rules(['required', 'digits_between:0,100'])
                    ->searchable()
                    ->sortable()
                    ->label('Kelas'),
                Tables\Columns\TextInputColumn::make('jumlah_rombel')
                    ->rules(['required', 'digits_between:0,100'])
                    ->searchable()
                    ->sortable()
                    ->label('Rombel'),
                Tables\Columns\TextInputColumn::make('jumlah_siswa')
                    ->rules(['required', 'digits_between:0,100'])
                    ->searchable()
                    ->sortable()
                    ->label('Siswa'),

                Tables\Columns\TextColumn::make('pegawai_kepsek_count')
                    ->counts('pegawaiKepsek')
                    ->icon(fn (string $state): string => $state == 1 ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (string $state): string => $state == 1 ? 'success' : 'danger')
                    ->sortable()
                    ->label('Kepsek'),
                Tables\Columns\TextColumn::make('pegawai_plt_kepsek_count')
                    ->counts('pegawaiPltKepsek')
                    ->icon(fn (string $state, Model $record): string => $state == 1 && $record->pegawaiKepsek()->count() == 0 ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (string $state, Model $record): string => $state == 1 && $record->pegawaiKepsek()->count() == 0 ? 'success' : 'danger')
                    ->sortable()
                    ->label('Plt'),

                Tables\Columns\TextColumn::make('pegawai_status_kepegawaian_pns_count')
                    ->counts('pegawaiStatusKepegawaianPns')
                    ->label('PNS'),
                Tables\Columns\TextColumn::make('pegawai_status_kepegawaian_pppk_count')
                    ->counts('pegawaiStatusKepegawaianPppk')
                    ->label('PPPK'),
                Tables\Columns\TextColumn::make('pegawai_status_kepegawaian_gtt_count')
                    ->counts('pegawaiStatusKepegawaianGtt')
                    ->label('GTT'),
                Tables\Columns\TextColumn::make('pegawai_count')
                    ->counts('pegawai')
                    ->label('JML'),

                Tables\Columns\TextInputColumn::make('sd_kelas_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('KLS ABK'),
                Tables\Columns\TextInputColumn::make('sd_kelas_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('KLS PNS'),
                Tables\Columns\TextInputColumn::make('sd_kelas_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('KLS PPPK'),
                Tables\Columns\TextInputColumn::make('sd_kelas_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('KLS GTT'),
                Tables\Columns\TextColumn::make('sd_kelas_jumlah')
                    ->description(fn (Model $record): string => $record->sd_kelas_jumlah_existing)
                    ->icon(fn (Model $record): string => $record->sd_kelas_abk == $record->sd_kelas_jumlah ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->sd_kelas_abk == $record->sd_kelas_jumlah ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('JML'),
                Tables\Columns\TextColumn::make('sd_kelas_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('+/- ABK'),
                Tables\Columns\TextColumn::make('sd_kelas_selisih_existing')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('+/- EXT'),

                Tables\Columns\TextInputColumn::make('sd_penjaskes_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('PJK ABK'),
                Tables\Columns\TextInputColumn::make('sd_penjaskes_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('PJK PNS'),
                Tables\Columns\TextInputColumn::make('sd_penjaskes_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('PJK PPPK'),
                Tables\Columns\TextInputColumn::make('sd_penjaskes_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('PJK GTT'),
                Tables\Columns\TextColumn::make('sd_penjaskes_jumlah')
                    ->description(fn (Model $record): string => $record->sd_penjaskes_jumlah_existing)
                    ->icon(fn (Model $record): string => $record->sd_penjaskes_abk == $record->sd_penjaskes_jumlah ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->sd_penjaskes_abk == $record->sd_penjaskes_jumlah ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('JML'),
                Tables\Columns\TextColumn::make('sd_penjaskes_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('+/- ABK'),
                Tables\Columns\TextColumn::make('sd_penjaskes_selisih_existing')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('+/- EXT'),

                Tables\Columns\TextInputColumn::make('sd_agama_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('AGM ABK'),
                Tables\Columns\TextInputColumn::make('sd_agama_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('AGM PNS'),
                Tables\Columns\TextInputColumn::make('sd_agama_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('AGM PPPK'),
                Tables\Columns\TextInputColumn::make('sd_agama_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('AGM GTT'),
                Tables\Columns\TextColumn::make('sd_agama_jumlah')
                    ->description(fn (Model $record): string => $record->sd_agama_jumlah_existing)
                    ->icon(fn (Model $record): string => $record->sd_agama_abk == $record->sd_agama_jumlah ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->sd_agama_abk == $record->sd_agama_jumlah ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('JML'),
                Tables\Columns\TextColumn::make('sd_agama_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('+/- ABK'),
                Tables\Columns\TextColumn::make('sd_agama_selisih_existing')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('+/- EXT'),

                Tables\Columns\TextInputColumn::make('sd_agama_noni_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('AGM NI ABK'),
                Tables\Columns\TextInputColumn::make('sd_agama_noni_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('AGM NI PNS'),
                Tables\Columns\TextInputColumn::make('sd_agama_noni_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('AGM NI PPPK'),
                Tables\Columns\TextInputColumn::make('sd_agama_noni_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('AGM NI GTT'),
                Tables\Columns\TextColumn::make('sd_agama_noni_jumlah')
                    ->description(fn (Model $record): string => $record->sd_agama_noni_jumlah_existing)
                    ->icon(fn (Model $record): string => $record->sd_agama_noni_abk == $record->sd_agama_noni_jumlah ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->sd_agama_noni_abk == $record->sd_agama_noni_jumlah ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('JML'),
                Tables\Columns\TextColumn::make('sd_agama_noni_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('+/- ABK'),
                Tables\Columns\TextColumn::make('sd_agama_noni_selisih_existing')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('+/- EXT'),


                Tables\Columns\TextInputColumn::make('smp_pai_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('PAI ABK'),
                Tables\Columns\TextInputColumn::make('smp_pai_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('PAI PNS'),
                Tables\Columns\TextInputColumn::make('smp_pai_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('PAI PPPK'),
                Tables\Columns\TextInputColumn::make('smp_pai_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('PAI GTT'),
                Tables\Columns\TextColumn::make('smp_pai_jumlah')
                    ->description(fn (Model $record): string => $record->smp_pai_jumlah_existing)
                    ->icon(fn (Model $record): string => $record->smp_pai_abk == $record->smp_pai_jumlah ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->smp_pai_abk == $record->smp_pai_jumlah ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('JML'),
                Tables\Columns\TextColumn::make('smp_pai_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- ABK'),
                Tables\Columns\TextColumn::make('smp_pai_selisih_existing')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- EXT'),

                Tables\Columns\TextInputColumn::make('smp_pjok_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('PJOK ABK'),
                Tables\Columns\TextInputColumn::make('smp_pjok_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('PJOK PNS'),
                Tables\Columns\TextInputColumn::make('smp_pjok_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('PJOK PPPK'),
                Tables\Columns\TextInputColumn::make('smp_pjok_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('PJOK GTT'),
                Tables\Columns\TextColumn::make('smp_pjok_jumlah')
                    ->description(fn (Model $record): string => $record->smp_pjok_jumlah_existing)
                    ->icon(fn (Model $record): string => $record->smp_pjok_abk == $record->smp_pjok_jumlah ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->smp_pjok_abk == $record->smp_pjok_jumlah ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('JML'),
                Tables\Columns\TextColumn::make('smp_pjok_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- ABK'),
                Tables\Columns\TextColumn::make('smp_pjok_selisih_existing')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- EXT'),

                Tables\Columns\TextInputColumn::make('smp_b_indonesia_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('BIND ABK'),
                Tables\Columns\TextInputColumn::make('smp_b_indonesia_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('BIND PNS'),
                Tables\Columns\TextInputColumn::make('smp_b_indonesia_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('BIND PPPK'),
                Tables\Columns\TextInputColumn::make('smp_b_indonesia_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('BIND GTT'),
                Tables\Columns\TextColumn::make('smp_b_indonesia_jumlah')
                    ->description(fn (Model $record): string => $record->smp_b_indonesia_jumlah_existing)
                    ->icon(fn (Model $record): string => $record->smp_b_indonesia_abk == $record->smp_b_indonesia_jumlah ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->smp_b_indonesia_abk == $record->smp_b_indonesia_jumlah ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('JML'),
                Tables\Columns\TextColumn::make('smp_b_indonesia_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- ABK'),
                Tables\Columns\TextColumn::make('smp_b_indonesia_selisih_existing')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- EXT'),

                Tables\Columns\TextInputColumn::make('smp_b_inggris_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('BING ABK'),
                Tables\Columns\TextInputColumn::make('smp_b_inggris_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('BING PNS'),
                Tables\Columns\TextInputColumn::make('smp_b_inggris_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('BING PPPK'),
                Tables\Columns\TextInputColumn::make('smp_b_inggris_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('BING GTT'),
                Tables\Columns\TextColumn::make('smp_b_inggris_jumlah')
                    ->description(fn (Model $record): string => $record->smp_b_inggris_jumlah_existing)
                    ->icon(fn (Model $record): string => $record->smp_b_inggris_abk == $record->smp_b_inggris_jumlah ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->smp_b_inggris_abk == $record->smp_b_inggris_jumlah ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('JML'),
                Tables\Columns\TextColumn::make('smp_b_inggris_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- ABK'),
                Tables\Columns\TextColumn::make('smp_b_inggris_selisih_existing')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- EXT'),

                Tables\Columns\TextInputColumn::make('smp_bk_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('BK ABK'),
                Tables\Columns\TextInputColumn::make('smp_bk_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('BK PNS'),
                Tables\Columns\TextInputColumn::make('smp_bk_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('BK PPPK'),
                Tables\Columns\TextInputColumn::make('smp_bk_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('BK GTT'),
                Tables\Columns\TextColumn::make('smp_bk_jumlah')
                    ->description(fn (Model $record): string => $record->smp_bk_jumlah_existing)
                    ->icon(fn (Model $record): string => $record->smp_bk_abk == $record->smp_bk_jumlah ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->smp_bk_abk == $record->smp_bk_jumlah ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('JML'),
                Tables\Columns\TextColumn::make('smp_bk_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- ABK'),
                Tables\Columns\TextColumn::make('smp_bk_selisih_existing')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- EXT'),

                Tables\Columns\TextInputColumn::make('smp_ipa_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('IPA ABK'),
                Tables\Columns\TextInputColumn::make('smp_ipa_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('IPA PNS'),
                Tables\Columns\TextInputColumn::make('smp_ipa_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('IPA PPPK'),
                Tables\Columns\TextInputColumn::make('smp_ipa_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('IPA GTT'),
                Tables\Columns\TextColumn::make('smp_ipa_jumlah')
                    ->description(fn (Model $record): string => $record->smp_ipa_jumlah_existing)
                    ->icon(fn (Model $record): string => $record->smp_ipa_abk == $record->smp_ipa_jumlah ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->smp_ipa_abk == $record->smp_ipa_jumlah ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('JML'),
                Tables\Columns\TextColumn::make('smp_ipa_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- ABK'),
                Tables\Columns\TextColumn::make('smp_ipa_selisih_existing')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- EXT'),

                Tables\Columns\TextInputColumn::make('smp_ips_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('IPS ABK'),
                Tables\Columns\TextInputColumn::make('smp_ips_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('IPS PNS'),
                Tables\Columns\TextInputColumn::make('smp_ips_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('IPS PPPK'),
                Tables\Columns\TextInputColumn::make('smp_ips_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('IPS GTT'),
                Tables\Columns\TextColumn::make('smp_ips_jumlah')
                    ->description(fn (Model $record): string => $record->smp_ips_jumlah_existing)
                    ->icon(fn (Model $record): string => $record->smp_ips_abk == $record->smp_ips_jumlah ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->smp_ips_abk == $record->smp_ips_jumlah ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('JML'),
                Tables\Columns\TextColumn::make('smp_ips_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- ABK'),
                Tables\Columns\TextColumn::make('smp_ips_selisih_existing')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- EXT'),

                Tables\Columns\TextInputColumn::make('smp_matematika_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('MTK ABK'),
                Tables\Columns\TextInputColumn::make('smp_matematika_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('MTK PNS'),
                Tables\Columns\TextInputColumn::make('smp_matematika_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('MTK PPPK'),
                Tables\Columns\TextInputColumn::make('smp_matematika_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('MTK GTT'),
                Tables\Columns\TextColumn::make('smp_matematika_jumlah')
                    ->description(fn (Model $record): string => $record->smp_matematika_jumlah_existing)
                    ->icon(fn (Model $record): string => $record->smp_matematika_abk == $record->smp_matematika_jumlah ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->smp_matematika_abk == $record->smp_matematika_jumlah ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('JML'),
                Tables\Columns\TextColumn::make('smp_matematika_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- ABK'),
                Tables\Columns\TextColumn::make('smp_matematika_selisih_existing')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- EXT'),

                Tables\Columns\TextInputColumn::make('smp_ppkn_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('PPKN ABK'),
                Tables\Columns\TextInputColumn::make('smp_ppkn_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('PPKN PNS'),
                Tables\Columns\TextInputColumn::make('smp_ppkn_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('PPKN PPPK'),
                Tables\Columns\TextInputColumn::make('smp_ppkn_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('PPKN GTT'),
                Tables\Columns\TextColumn::make('smp_ppkn_jumlah')
                    ->description(fn (Model $record): string => $record->smp_ppkn_jumlah_existing)
                    ->icon(fn (Model $record): string => $record->smp_ppkn_abk == $record->smp_ppkn_jumlah ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->smp_ppkn_abk == $record->smp_ppkn_jumlah ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('JML'),
                Tables\Columns\TextColumn::make('smp_ppkn_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- ABK'),
                Tables\Columns\TextColumn::make('smp_ppkn_selisih_existing')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- EXT'),

                Tables\Columns\TextInputColumn::make('smp_prakarya_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('PKY ABK'),
                Tables\Columns\TextInputColumn::make('smp_prakarya_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('PKY PNS'),
                Tables\Columns\TextInputColumn::make('smp_prakarya_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('PKY PPPK'),
                Tables\Columns\TextInputColumn::make('smp_prakarya_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('PKY GTT'),
                Tables\Columns\TextColumn::make('smp_prakarya_jumlah')
                    ->description(fn (Model $record): string => $record->smp_prakarya_jumlah_existing)
                    ->icon(fn (Model $record): string => $record->smp_prakarya_abk == $record->smp_prakarya_jumlah ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->smp_prakarya_abk == $record->smp_prakarya_jumlah ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('JML'),
                Tables\Columns\TextColumn::make('smp_prakarya_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- ABK'),
                Tables\Columns\TextColumn::make('smp_prakarya_selisih_existing')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- EXT'),

                Tables\Columns\TextInputColumn::make('smp_seni_budaya_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('SEBUD ABK'),
                Tables\Columns\TextInputColumn::make('smp_seni_budaya_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('SEBUD PNS'),
                Tables\Columns\TextInputColumn::make('smp_seni_budaya_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('SEBUD PPPK'),
                Tables\Columns\TextInputColumn::make('smp_seni_budaya_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('SEBUD GTT'),
                Tables\Columns\TextColumn::make('smp_seni_budaya_jumlah')
                    ->description(fn (Model $record): string => $record->smp_seni_budaya_jumlah_existing)
                    ->icon(fn (Model $record): string => $record->smp_seni_budaya_abk == $record->smp_seni_budaya_jumlah ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->smp_seni_budaya_abk == $record->smp_seni_budaya_jumlah ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('JML'),
                Tables\Columns\TextColumn::make('smp_seni_budaya_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- ABK'),
                Tables\Columns\TextColumn::make('smp_seni_budaya_selisih_existing')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- EXT'),

                Tables\Columns\TextInputColumn::make('smp_b_sunda_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('BSUN ABK'),
                Tables\Columns\TextInputColumn::make('smp_b_sunda_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('BSUN PNS'),
                Tables\Columns\TextInputColumn::make('smp_b_sunda_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('BSUN PPPK'),
                Tables\Columns\TextInputColumn::make('smp_b_sunda_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('BSUN GTT'),
                Tables\Columns\TextColumn::make('smp_b_sunda_jumlah')
                    ->description(fn (Model $record): string => $record->smp_b_sunda_jumlah_existing)
                    ->icon(fn (Model $record): string => $record->smp_b_sunda_abk == $record->smp_b_sunda_jumlah ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->smp_b_sunda_abk == $record->smp_b_sunda_jumlah ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('JML'),
                Tables\Columns\TextColumn::make('smp_b_sunda_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- ABK'),
                Tables\Columns\TextColumn::make('smp_b_sunda_selisih_existing')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- EXT'),

                Tables\Columns\TextInputColumn::make('smp_tik_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('TIK ABK'),
                Tables\Columns\TextInputColumn::make('smp_tik_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('TIK PNS'),
                Tables\Columns\TextInputColumn::make('smp_tik_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('TIK PPPK'),
                Tables\Columns\TextInputColumn::make('smp_tik_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->rules(['required', 'digits_between:0,100'])
                    ->label('TIK GTT'),
                Tables\Columns\TextColumn::make('smp_tik_jumlah')
                    ->description(fn (Model $record): string => $record->smp_tik_jumlah_existing)
                    ->icon(fn (Model $record): string => $record->smp_tik_abk == $record->smp_tik_jumlah ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->smp_tik_abk == $record->smp_tik_jumlah ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('JML'),
                Tables\Columns\TextColumn::make('smp_tik_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- ABK'),
                Tables\Columns\TextColumn::make('smp_tik_selisih_existing')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- EXT'),

                Tables\Columns\TextColumn::make('sd_jumlah_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('JML ABK'),
                Tables\Columns\TextColumn::make('sd_jumlah_formasi')
                    ->description(fn (Model $record): string => $record->sd_jumlah_existing)
                    ->icon(fn (Model $record): string => $record->sd_jumlah_abk == $record->sd_jumlah_formasi ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->sd_jumlah_abk == $record->sd_jumlah_formasi ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('JML FMS'),
                Tables\Columns\TextColumn::make('sd_jumlah_selisih')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('+/- ABK'),
                Tables\Columns\TextColumn::make('sd_jumlah_selisih_existing')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('+/- ABK EXT'),

                Tables\Columns\TextColumn::make('smp_jumlah_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('JML ABK'),
                Tables\Columns\TextColumn::make('smp_jumlah_formasi')
                    ->description(fn (Model $record): string => $record->smp_jumlah_existing)
                    ->icon(fn (Model $record): string => $record->smp_jumlah_abk == $record->smp_jumlah_formasi ? 'heroicon-o-check' : 'heroicon-o-x-mark')
                    ->color(fn (Model $record): string => $record->smp_jumlah_abk == $record->smp_jumlah_formasi ? 'success' : 'danger')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('JML FMS'),
                Tables\Columns\TextColumn::make('smp_jumlah_selisih')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- ABK'),
                Tables\Columns\TextColumn::make('smp_jumlah_selisih_existing')
                    ->badge()
                    ->color(fn ($state): string => $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray'))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('+/- ABK EXT'),
            ])
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
