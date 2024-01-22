<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Kanekescom\Simgtk\Enums\StatusKepegawaianEnum;
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
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Profil')
                            ->schema([
                                Forms\Components\TextInput::make('nama')
                                    ->maxLength(255)
                                    ->required()
                                    ->disabledOn('edit')
                                    ->label('Nama'),
                                Forms\Components\TextInput::make('npsn')
                                    ->numeric()
                                    ->length(8)
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->disabledOn('edit')
                                    ->label('NPSN'),
                                Forms\Components\Select::make('jenjang_sekolah_id')
                                    ->relationship('jenjangSekolah', 'nama')
                                    ->exists(table: JenjangSekolah::class, column: 'id')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->disabledOn('edit')
                                    ->label('Jenjang Sekolah'),
                                Forms\Components\Select::make('wilayah_id')
                                    ->relationship('wilayah', 'nama')
                                    ->exists()
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->disabledOn('edit')
                                    ->label('Wilayah'),
                            ])->columns(2),
                        Tabs\Tab::make('Data')
                            ->schema([
                                Forms\Components\TextInput::make('jumlah_kelas')
                                    ->integer()
                                    ->minValue(0)
                                    ->maxValue(10000)
                                    ->required()
                                    ->label('Jumlah Kelas'),
                                Forms\Components\TextInput::make('jumlah_rombel')
                                    ->integer()
                                    ->minValue(0)
                                    ->maxValue(10000)
                                    ->required()
                                    ->label('Jumlah Rombel'),
                                Forms\Components\TextInput::make('jumlah_siswa')
                                    ->integer()
                                    ->minValue(0)
                                    ->maxValue(10000)
                                    ->required()
                                    ->label('Jumlah Siswa'),
                            ])->columns(3),
                    ]),
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

                Tables\Columns\TextInputColumn::make('sd_kelas_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Kelas ABK'),
                Tables\Columns\TextInputColumn::make('sd_kelas_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Kelas PNS'),
                Tables\Columns\TextInputColumn::make('sd_kelas_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Kelas PPPK'),
                Tables\Columns\TextInputColumn::make('sd_kelas_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Kelas GTT'),
                Tables\Columns\TextColumn::make('sd_kelas_jumlah')
                    ->description(fn (Sekolah $record): string => $record->mataPelajaranSdKelas()->count())
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('sd_kelas_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('sd_penjaskes_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Penjaskes ABK'),
                Tables\Columns\TextInputColumn::make('sd_penjaskes_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Penjaskes PNS'),
                Tables\Columns\TextInputColumn::make('sd_penjaskes_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Penjaskes PPPK'),
                Tables\Columns\TextInputColumn::make('sd_penjaskes_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Penjaskes GTT'),
                Tables\Columns\TextColumn::make('sd_penjaskes_jumlah')
                    ->description(fn (Sekolah $record): string => $record->mataPelajaranSdPenjaskes()->count())
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('sd_penjaskes_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('sd_agama_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Agama ABK'),
                Tables\Columns\TextInputColumn::make('sd_agama_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Agama PNS'),
                Tables\Columns\TextInputColumn::make('sd_agama_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Agama PPPK'),
                Tables\Columns\TextInputColumn::make('sd_agama_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Agama GTT'),
                Tables\Columns\TextColumn::make('sd_agama_jumlah')
                    ->description(fn (Sekolah $record): string => $record->mataPelajaranSdAgama()->count())
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('sd_agama_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('sd_agama_noni_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Agama ABK'),
                Tables\Columns\TextInputColumn::make('sd_agama_noni_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Agama PNS'),
                Tables\Columns\TextInputColumn::make('sd_agama_noni_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Agama PPPK'),
                Tables\Columns\TextInputColumn::make('sd_agama_noni_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Agama GTT'),
                Tables\Columns\TextColumn::make('sd_agama_noni_jumlah')
                    ->description(fn (Sekolah $record): string => $record->mataPelajaranSdAgamaNoni()->count())
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('sd_agama_noni_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_pai_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('PAI ABK'),
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
                    ->description(fn (Sekolah $record): string => $record->mataPelajaranSmpPai()->count())
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_pai_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_pjok_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('PJOK ABK'),
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
                    ->description(fn (Sekolah $record): string => $record->mataPelajaranSmpPjok()->count())
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_pjok_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_b_indonesia_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('B. Indonesia ABK'),
                Tables\Columns\TextInputColumn::make('smp_b_indonesia_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('B. Indonesia PNS'),
                Tables\Columns\TextInputColumn::make('smp_b_indonesia_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('B. Indonesia PPPK'),
                Tables\Columns\TextInputColumn::make('smp_b_indonesia_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('B. Indonesia GTT'),
                Tables\Columns\TextColumn::make('smp_b_indonesia_jumlah')
                    ->description(fn (Sekolah $record): string => $record->mataPelajaranSmpBIndonesia()->count())
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_b_indonesia_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_b_inggris_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('B. Inggris ABK'),
                Tables\Columns\TextInputColumn::make('smp_b_inggris_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('B. Inggris PNS'),
                Tables\Columns\TextInputColumn::make('smp_b_inggris_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('B. Inggris PPPK'),
                Tables\Columns\TextInputColumn::make('smp_b_inggris_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('B. Inggris GTT'),
                Tables\Columns\TextColumn::make('smp_b_inggris_jumlah')
                    ->description(fn (Sekolah $record): string => $record->mataPelajaranSmpBInggris()->count())
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_b_inggris_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_bk_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('BK ABK'),
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
                    ->description(fn (Sekolah $record): string => $record->mataPelajaranSmpBk()->count())
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_bk_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_ipa_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('IPA ABK'),
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
                    ->description(fn (Sekolah $record): string => $record->mataPelajaranSmpIpa()->count())
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_ipa_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_ips_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('IPS ABK'),
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
                    ->description(fn (Sekolah $record): string => $record->mataPelajaranSmpIps()->count())
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_ips_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_matematika_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Matematika ABK'),
                Tables\Columns\TextInputColumn::make('smp_matematika_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Matematika PNS'),
                Tables\Columns\TextInputColumn::make('smp_matematika_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Matematika PPPK'),
                Tables\Columns\TextInputColumn::make('smp_matematika_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Matematika GTT'),
                Tables\Columns\TextColumn::make('smp_matematika_jumlah')
                    ->description(fn (Sekolah $record): string => $record->mataPelajaranSmpMatematika()->count())
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_matematika_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_pppkn_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('PPPKN ABK'),
                Tables\Columns\TextInputColumn::make('smp_pppkn_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('PPPKN PNS'),
                Tables\Columns\TextInputColumn::make('smp_pppkn_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('PPPKN PPPK'),
                Tables\Columns\TextInputColumn::make('smp_pppkn_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('PPPKN GTT'),
                Tables\Columns\TextColumn::make('smp_pppkn_jumlah')
                    ->description(fn (Sekolah $record): string => $record->mataPelajaranSmpPpkn()->count())
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_pppkn_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_prakarya_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Prakarya ABK'),
                Tables\Columns\TextInputColumn::make('smp_prakarya_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Prakarya PNS'),
                Tables\Columns\TextInputColumn::make('smp_prakarya_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Prakarya PPPK'),
                Tables\Columns\TextInputColumn::make('smp_prakarya_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Prakarya GTT'),
                Tables\Columns\TextColumn::make('smp_prakarya_jumlah')
                    ->description(fn (Sekolah $record): string => $record->mataPelajaranSmpPrakarya()->count())
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_prakarya_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_seni_budaya_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Seni Budaya ABK'),
                Tables\Columns\TextInputColumn::make('smp_seni_budaya_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Seni Budaya PNS'),
                Tables\Columns\TextInputColumn::make('smp_seni_budaya_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Seni Budaya PPPK'),
                Tables\Columns\TextInputColumn::make('smp_seni_budaya_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Seni Budaya GTT'),
                Tables\Columns\TextColumn::make('smp_seni_budaya_jumlah')
                    ->description(fn (Sekolah $record): string => $record->mataPelajaranSmpSeniBudaya()->count())
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_seni_budaya_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_b_sunda_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('B. Sunda ABK'),
                Tables\Columns\TextInputColumn::make('smp_b_sunda_pns')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('B. Sunda PNS'),
                Tables\Columns\TextInputColumn::make('smp_b_sunda_pppk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('B. Sunda PPPK'),
                Tables\Columns\TextInputColumn::make('smp_b_sunda_gtt')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('B. Sunda GTT'),
                Tables\Columns\TextColumn::make('smp_b_sunda_jumlah')
                    ->description(fn (Sekolah $record): string => $record->mataPelajaranSmpBSunda()->count())
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_b_sunda_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_tik_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('TIK ABK'),
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
                    ->description(fn (Sekolah $record): string => $record->mataPelajaranSmpTik()->count())
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_tik_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Selisih'),

                Tables\Columns\TextColumn::make('pegawai_status_kepegawaian_pns_count')
                    ->counts('pegawaiStatusKepegawaianPns')
                    ->label('Jumlah Guru PNS'),
                Tables\Columns\TextColumn::make('pegawai_status_kepegawaian_pppk_count')
                    ->counts('pegawaiStatusKepegawaianPppk')
                    ->label('Jumlah Guru PPPK'),
                Tables\Columns\TextColumn::make('pegawai_status_kepegawaian_gtt_count')
                    ->counts('pegawaiStatusKepegawaianGtt')
                    ->label('Jumlah Guru GTT'),
                Tables\Columns\TextColumn::make('pegawai_count')
                    ->counts('pegawai')
                    ->label('Jumlah Guru'),

                Tables\Columns\TextColumn::make('sd_jumlah_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Jumlah ABK SD'),
                Tables\Columns\TextColumn::make('sd_jumlah_formasi')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Jumlah Formasi SD'),
                Tables\Columns\TextColumn::make('sd_jumlah_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'sd')
                    ->label('Jumlah Selisih SD'),

                Tables\Columns\TextColumn::make('smp_jumlah_abk')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah ABK SMP'),
                Tables\Columns\TextColumn::make('smp_jumlah_formasi')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah Formasi SMP'),
                Tables\Columns\TextColumn::make('smp_jumlah_selisih')
                    ->visible(fn ($livewire) => $livewire->activeTab === 'smp')
                    ->label('Jumlah Selisih SMP'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('wilayah_id')
                    ->relationship('wilayah', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Wilayah'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'edit' => Pages\EditBezzeting::route('/{record}/edit'),
        ];
    }
}
