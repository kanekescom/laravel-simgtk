<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Kanekescom\Simgtk\Filament\Resources\BezzetingResource\Pages;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\Sekolah;

class BezzetingResource extends Resource
{
    protected static ?string $slug = 'bezzeting';

    protected static ?string $pluralLabel = 'Bezzeting';

    protected static ?string $model = Sekolah::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Bezzeting';

    protected static ?string $navigationGroup = null;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup('wilayah.nama')
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),
                Tables\Columns\TextInputColumn::make('jumlah_kelas')
                    ->searchable()
                    ->sortable()
                    ->label('Kelas'),
                Tables\Columns\TextInputColumn::make('jumlah_rombel')
                    ->searchable()
                    ->sortable()
                    ->label('Rombel'),
                Tables\Columns\TextInputColumn::make('jumlah_siswa')
                    ->searchable()
                    ->sortable()
                    ->label('Siswa'),

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
                    ->label('Jumlah'),

                // Tables\Columns\TextInputColumn::make('sd_kelas_abk')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                //     ->label('KELAS ABK'),
                Tables\Columns\TextInputColumn::make('sd_kelas_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('KELAS PNS'),
                Tables\Columns\TextInputColumn::make('sd_kelas_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('KELAS PPPK'),
                Tables\Columns\TextInputColumn::make('sd_kelas_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('KELAS GTT'),
                Tables\Columns\TextColumn::make('sd_kelas_jumlah')
                    ->description(fn (Sekolah $record): string => $record->sd_kelas_jumlah_existing)
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Jumlah'),
                // Tables\Columns\TextColumn::make('sd_kelas_selisih')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                //     ->label('Selisih'),
                Tables\Columns\TextColumn::make('sd_kelas_selisih_existing')
                    ->badge()
                    ->color(function ($state) {
                        return $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray');
                    })
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Selisih'),

                // Tables\Columns\TextInputColumn::make('sd_penjaskes_abk')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                //     ->label('PENJAS ABK'),
                Tables\Columns\TextInputColumn::make('sd_penjaskes_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('PENJAS PNS'),
                Tables\Columns\TextInputColumn::make('sd_penjaskes_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('PENJAS PPPK'),
                Tables\Columns\TextInputColumn::make('sd_penjaskes_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('PENJAS GTT'),
                Tables\Columns\TextColumn::make('sd_penjaskes_jumlah')
                    ->description(fn (Sekolah $record): string => $record->sd_penjaskes_jumlah_existing)
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Jumlah'),
                // Tables\Columns\TextColumn::make('sd_penjaskes_selisih')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                //     ->label('Selisih'),
                Tables\Columns\TextColumn::make('sd_penjaskes_selisih_existing')
                    ->badge()
                    ->color(function ($state) {
                        return $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray');
                    })
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Selisih'),

                // Tables\Columns\TextInputColumn::make('sd_agama_abk')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                //     ->label('AGAMA ABK'),
                Tables\Columns\TextInputColumn::make('sd_agama_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('AGAMA PNS'),
                Tables\Columns\TextInputColumn::make('sd_agama_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('AGAMA PPPK'),
                Tables\Columns\TextInputColumn::make('sd_agama_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('AGAMA GTT'),
                Tables\Columns\TextColumn::make('sd_agama_jumlah')
                    ->description(fn (Sekolah $record): string => $record->sd_agama_jumlah_existing)
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Jumlah'),
                // Tables\Columns\TextColumn::make('sd_agama_selisih')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                //     ->label('Selisih'),
                Tables\Columns\TextColumn::make('sd_agama_selisih_existing')
                    ->badge()
                    ->color(function ($state) {
                        return $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray');
                    })
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Selisih'),

                // Tables\Columns\TextInputColumn::make('sd_agama_noni_abk')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                //     ->label('AGAMA ABK'),
                Tables\Columns\TextInputColumn::make('sd_agama_noni_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('AGAMA PNS'),
                Tables\Columns\TextInputColumn::make('sd_agama_noni_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('AGAMA PPPK'),
                Tables\Columns\TextInputColumn::make('sd_agama_noni_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('AGAMA GTT'),
                Tables\Columns\TextColumn::make('sd_agama_noni_jumlah')
                    ->description(fn (Sekolah $record): string => $record->sd_agama_noni_jumlah_existing)
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Jumlah'),
                // Tables\Columns\TextColumn::make('sd_agama_noni_selisih')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                //     ->label('Selisih'),
                Tables\Columns\TextColumn::make('sd_agama_noni_selisih_existing')
                    ->badge()
                    ->color(function ($state) {
                        return $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray');
                    })
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Selisih'),

                // Tables\Columns\TextInputColumn::make('smp_pai_abk')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('PAI ABK'),
                Tables\Columns\TextInputColumn::make('smp_pai_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('PAI PNS'),
                Tables\Columns\TextInputColumn::make('smp_pai_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('PAI PPPK'),
                Tables\Columns\TextInputColumn::make('smp_pai_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('PAI GTT'),
                Tables\Columns\TextColumn::make('smp_pai_jumlah')
                    ->description(fn (Sekolah $record): string => $record->smp_pai_jumlah_existing)
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                // Tables\Columns\TextColumn::make('smp_pai_selisih')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('Selisih'),
                Tables\Columns\TextColumn::make('smp_pai_selisih_existing')
                    ->badge()
                    ->color(function ($state) {
                        return $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray');
                    })
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                // Tables\Columns\TextInputColumn::make('smp_pjok_abk')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('PJOK ABK'),
                Tables\Columns\TextInputColumn::make('smp_pjok_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('PJOK PNS'),
                Tables\Columns\TextInputColumn::make('smp_pjok_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('PJOK PPPK'),
                Tables\Columns\TextInputColumn::make('smp_pjok_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('PJOK GTT'),
                Tables\Columns\TextColumn::make('smp_pjok_jumlah')
                    ->description(fn (Sekolah $record): string => $record->smp_pjok_jumlah_existing)
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                // Tables\Columns\TextColumn::make('smp_pjok_selisih')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('Selisih'),
                Tables\Columns\TextColumn::make('smp_pjok_selisih_existing')
                    ->badge()
                    ->color(function ($state) {
                        return $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray');
                    })
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                // Tables\Columns\TextInputColumn::make('smp_b_indonesia_abk')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('B.IND ABK'),
                Tables\Columns\TextInputColumn::make('smp_b_indonesia_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('B.IND PNS'),
                Tables\Columns\TextInputColumn::make('smp_b_indonesia_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('B.IND PPPK'),
                Tables\Columns\TextInputColumn::make('smp_b_indonesia_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('B.IND GTT'),
                Tables\Columns\TextColumn::make('smp_b_indonesia_jumlah')
                    ->description(fn (Sekolah $record): string => $record->smp_b_indonesia_jumlah_existing)
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                // Tables\Columns\TextColumn::make('smp_b_indonesia_selisih')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('Selisih'),
                Tables\Columns\TextColumn::make('smp_b_indonesia_selisih_existing')
                    ->badge()
                    ->color(function ($state) {
                        return $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray');
                    })
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                // Tables\Columns\TextInputColumn::make('smp_b_inggris_abk')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('B.ING ABK'),
                Tables\Columns\TextInputColumn::make('smp_b_inggris_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('B.ING PNS'),
                Tables\Columns\TextInputColumn::make('smp_b_inggris_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('B.ING PPPK'),
                Tables\Columns\TextInputColumn::make('smp_b_inggris_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('B.ING GTT'),
                Tables\Columns\TextColumn::make('smp_b_inggris_jumlah')
                    ->description(fn (Sekolah $record): string => $record->smp_b_inggris_jumlah_existing)
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                // Tables\Columns\TextColumn::make('smp_b_inggris_selisih')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('Selisih'),
                Tables\Columns\TextColumn::make('smp_b_inggris_selisih_existing')
                    ->badge()
                    ->color(function ($state) {
                        return $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray');
                    })
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                // Tables\Columns\TextInputColumn::make('smp_bk_abk')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('BK ABK'),
                Tables\Columns\TextInputColumn::make('smp_bk_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('BK PNS'),
                Tables\Columns\TextInputColumn::make('smp_bk_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('BK PPPK'),
                Tables\Columns\TextInputColumn::make('smp_bk_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('BK GTT'),
                Tables\Columns\TextColumn::make('smp_bk_jumlah')
                    ->description(fn (Sekolah $record): string => $record->smp_bk_jumlah_existing)
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                // Tables\Columns\TextColumn::make('smp_bk_selisih')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('Selisih'),
                Tables\Columns\TextColumn::make('smp_bk_selisih_existing')
                    ->badge()
                    ->color(function ($state) {
                        return $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray');
                    })
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                // Tables\Columns\TextInputColumn::make('smp_ipa_abk')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('IPA ABK'),
                Tables\Columns\TextInputColumn::make('smp_ipa_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('IPA PNS'),
                Tables\Columns\TextInputColumn::make('smp_ipa_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('IPA PPPK'),
                Tables\Columns\TextInputColumn::make('smp_ipa_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('IPA GTT'),
                Tables\Columns\TextColumn::make('smp_ipa_jumlah')
                    ->description(fn (Sekolah $record): string => $record->smp_ipa_jumlah_existing)
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                // Tables\Columns\TextColumn::make('smp_ipa_selisih')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('Selisih'),
                Tables\Columns\TextColumn::make('smp_ipa_selisih_existing')
                    ->badge()
                    ->color(function ($state) {
                        return $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray');
                    })
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                // Tables\Columns\TextInputColumn::make('smp_ips_abk')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('IPS ABK'),
                Tables\Columns\TextInputColumn::make('smp_ips_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('IPS PNS'),
                Tables\Columns\TextInputColumn::make('smp_ips_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('IPS PPPK'),
                Tables\Columns\TextInputColumn::make('smp_ips_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('IPS GTT'),
                Tables\Columns\TextColumn::make('smp_ips_jumlah')
                    ->description(fn (Sekolah $record): string => $record->smp_ips_jumlah_existing)
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                // Tables\Columns\TextColumn::make('smp_ips_selisih')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('Selisih'),
                Tables\Columns\TextColumn::make('smp_ips_selisih_existing')
                    ->badge()
                    ->color(function ($state) {
                        return $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray');
                    })
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                // Tables\Columns\TextInputColumn::make('smp_matematika_abk')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('MTK ABK'),
                Tables\Columns\TextInputColumn::make('smp_matematika_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('MTK PNS'),
                Tables\Columns\TextInputColumn::make('smp_matematika_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('MTK PPPK'),
                Tables\Columns\TextInputColumn::make('smp_matematika_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('MTK GTT'),
                Tables\Columns\TextColumn::make('smp_matematika_jumlah')
                    ->description(fn (Sekolah $record): string => $record->smp_matematika_jumlah_existing)
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                // Tables\Columns\TextColumn::make('smp_matematika_selisih')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('Selisih'),
                Tables\Columns\TextColumn::make('smp_matematika_selisih_existing')
                    ->badge()
                    ->color(function ($state) {
                        return $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray');
                    })
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                // Tables\Columns\TextInputColumn::make('smp_ppkn_abk')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('PPKN ABK'),
                Tables\Columns\TextInputColumn::make('smp_ppkn_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('PPKN PNS'),
                Tables\Columns\TextInputColumn::make('smp_ppkn_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('PPKN PPPK'),
                Tables\Columns\TextInputColumn::make('smp_ppkn_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('PPKN GTT'),
                Tables\Columns\TextColumn::make('smp_ppkn_jumlah')
                    ->description(fn (Sekolah $record): string => $record->smp_ppkn_jumlah_existing)
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                // Tables\Columns\TextColumn::make('smp_ppkn_selisih')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('Selisih'),
                Tables\Columns\TextColumn::make('smp_ppkn_selisih_existing')
                    ->badge()
                    ->color(function ($state) {
                        return $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray');
                    })
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                // Tables\Columns\TextInputColumn::make('smp_prakarya_abk')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('PRKY ABK'),
                Tables\Columns\TextInputColumn::make('smp_prakarya_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('PRKY PNS'),
                Tables\Columns\TextInputColumn::make('smp_prakarya_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('PRKY PPPK'),
                Tables\Columns\TextInputColumn::make('smp_prakarya_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('PRKY GTT'),
                Tables\Columns\TextColumn::make('smp_prakarya_jumlah')
                    ->description(fn (Sekolah $record): string => $record->smp_prakarya_jumlah_existing)
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                // Tables\Columns\TextColumn::make('smp_prakarya_selisih')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('Selisih'),
                Tables\Columns\TextColumn::make('smp_prakarya_selisih_existing')
                    ->badge()
                    ->color(function ($state) {
                        return $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray');
                    })
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                // Tables\Columns\TextInputColumn::make('smp_seni_budaya_abk')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('SEBUD ABK'),
                Tables\Columns\TextInputColumn::make('smp_seni_budaya_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('SEBUD PNS'),
                Tables\Columns\TextInputColumn::make('smp_seni_budaya_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('SEBUD PPPK'),
                Tables\Columns\TextInputColumn::make('smp_seni_budaya_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('SEBUD GTT'),
                Tables\Columns\TextColumn::make('smp_seni_budaya_jumlah')
                    ->description(fn (Sekolah $record): string => $record->smp_seni_budaya_jumlah_existing)
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                // Tables\Columns\TextColumn::make('smp_seni_budaya_selisih')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('Selisih'),
                Tables\Columns\TextColumn::make('smp_seni_budaya_selisih_existing')
                    ->badge()
                    ->color(function ($state) {
                        return $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray');
                    })
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                // Tables\Columns\TextInputColumn::make('smp_b_sunda_abk')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('B.SUN ABK'),
                Tables\Columns\TextInputColumn::make('smp_b_sunda_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('B.SUN PNS'),
                Tables\Columns\TextInputColumn::make('smp_b_sunda_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('B.SUN PPPK'),
                Tables\Columns\TextInputColumn::make('smp_b_sunda_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('B.SUN GTT'),
                Tables\Columns\TextColumn::make('smp_b_sunda_jumlah')
                    ->description(fn (Sekolah $record): string => $record->smp_b_sunda_jumlah_existing)
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                // Tables\Columns\TextColumn::make('smp_b_sunda_selisih')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('Selisih'),
                Tables\Columns\TextColumn::make('smp_b_sunda_selisih_existing')
                    ->badge()
                    ->color(function ($state) {
                        return $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray');
                    })
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                // Tables\Columns\TextInputColumn::make('smp_tik_abk')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('TIK ABK'),
                Tables\Columns\TextInputColumn::make('smp_tik_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('TIK PNS'),
                Tables\Columns\TextInputColumn::make('smp_tik_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('TIK PPPK'),
                Tables\Columns\TextInputColumn::make('smp_tik_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('TIK GTT'),
                Tables\Columns\TextColumn::make('smp_tik_jumlah')
                    ->description(fn (Sekolah $record): string => $record->smp_tik_jumlah_existing)
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                // Tables\Columns\TextColumn::make('smp_tik_selisih')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('Selisih'),
                Tables\Columns\TextColumn::make('smp_tik_selisih_existing')
                    ->badge()
                    ->color(function ($state) {
                        return $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray');
                    })
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                // Tables\Columns\TextColumn::make('sd_jumlah_abk')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                //     ->label('Jumlah ABK'),
                Tables\Columns\TextColumn::make('sd_jumlah_formasi')
                    ->description(fn (Sekolah $record): string => $record->sd_jumlah_existing)
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Jumlah Formasi'),
                // Tables\Columns\TextColumn::make('sd_jumlah_selisih')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                //     ->label('Jumlah Selisih'),
                Tables\Columns\TextColumn::make('sd_jumlah_selisih_existing')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Jumlah Selisih'),

                // Tables\Columns\TextColumn::make('smp_jumlah_abk')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('Jumlah ABK'),
                Tables\Columns\TextColumn::make('smp_jumlah_formasi')
                    ->description(fn (Sekolah $record): string => $record->smp_jumlah_existing)
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah Formasi'),
                // Tables\Columns\TextColumn::make('smp_jumlah_selisih')
                //     ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                //     ->label('Jumlah Selisih'),
                Tables\Columns\TextColumn::make('smp_jumlah_selisih_existing')
                    ->badge()
                    ->color(function ($state) {
                        return $state < 0 ? 'success' : ($state > 0 ? 'danger' : 'gray');
                    })
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah Selisih'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('wilayah_id')
                    ->relationship('wilayah', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Wilayah'),
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ])
            ->emptyStateActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBezzeting::route('/'),
        ];
    }
}
