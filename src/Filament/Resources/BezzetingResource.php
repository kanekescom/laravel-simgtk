<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Tabs;
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
                                Forms\Components\Select::make('wilayah_kode')
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
                    ])
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
                    ->visible(function (){
                        return in_array(request()->query('activeTab'), ['','01hmmgv93qdr4j7qpaba7dapw4']);
                    })
                    ->label('Kelas ABK'),
                Tables\Columns\TextInputColumn::make('sd_kelas_pns')
                    ->visible(function (){
                        return in_array(request()->query('activeTab'), ['','01hmmgv93qdr4j7qpaba7dapw4']);
                    })
                    ->label('Kelas PNS'),
                Tables\Columns\TextInputColumn::make('sd_kelas_pppk')
                    ->visible(function (){
                        return in_array(request()->query('activeTab'), ['','01hmmgv93qdr4j7qpaba7dapw4']);
                    })
                    ->label('Kelas PPPK'),
                Tables\Columns\TextInputColumn::make('sd_kelas_gtt')
                    ->visible(function (){
                        return in_array(request()->query('activeTab'), ['','01hmmgv93qdr4j7qpaba7dapw4']);
                    })
                    ->label('Kelas GTT'),
                Tables\Columns\TextColumn::make('sd_kelas_jumlah')
                    ->visible(function (){
                        return in_array(request()->query('activeTab'), ['','01hmmgv93qdr4j7qpaba7dapw4']);
                    })
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('sd_kelas_selisih')
                    ->visible(function (){
                        return in_array(request()->query('activeTab'), ['','01hmmgv93qdr4j7qpaba7dapw4']);
                    })
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('sd_penjaskes_abk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Penjaskes ABK'),
                Tables\Columns\TextInputColumn::make('sd_penjaskes_pns')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Penjaskes PNS'),
                Tables\Columns\TextInputColumn::make('sd_penjaskes_pppk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Penjaskes PPPK'),
                Tables\Columns\TextInputColumn::make('sd_penjaskes_gtt')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Penjaskes GTT'),
                Tables\Columns\TextColumn::make('sd_penjaskes_jumlah')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('sd_penjaskes_selisih')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('sd_agama_abk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Agama ABK'),
                Tables\Columns\TextInputColumn::make('sd_agama_pns')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Agama PNS'),
                Tables\Columns\TextInputColumn::make('sd_agama_pppk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Agama PPPK'),
                Tables\Columns\TextInputColumn::make('sd_agama_gtt')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Agama GTT'),
                Tables\Columns\TextColumn::make('sd_agama_jumlah')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('sd_agama_selisih')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_pai_abk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('PAI ABK'),
                Tables\Columns\TextInputColumn::make('smp_pai_pns')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('PAI PNS'),
                Tables\Columns\TextInputColumn::make('smp_pai_pppk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('PAI PPPK'),
                Tables\Columns\TextInputColumn::make('smp_pai_gtt')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('PAI GTT'),
                Tables\Columns\TextColumn::make('smp_pai_jumlah')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_pai_selisih')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_pjok_abk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('PJOK ABK'),
                Tables\Columns\TextInputColumn::make('smp_pjok_pns')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('PJOK PNS'),
                Tables\Columns\TextInputColumn::make('smp_pjok_pppk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('PJOK PPPK'),
                Tables\Columns\TextInputColumn::make('smp_pjok_gtt')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('PJOK GTT'),
                Tables\Columns\TextColumn::make('smp_pjok_jumlah')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_pjok_selisih')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_b_indonesia_abk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('B. Indonesia ABK'),
                Tables\Columns\TextInputColumn::make('smp_b_indonesia_pns')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('B. Indonesia PNS'),
                Tables\Columns\TextInputColumn::make('smp_b_indonesia_pppk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('B. Indonesia PPPK'),
                Tables\Columns\TextInputColumn::make('smp_b_indonesia_gtt')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('B. Indonesia GTT'),
                Tables\Columns\TextColumn::make('smp_b_indonesia_jumlah')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_b_indonesia_selisih')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_b_inggris_abk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('B. Inggris ABK'),
                Tables\Columns\TextInputColumn::make('smp_b_inggris_pns')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('B. Inggris PNS'),
                Tables\Columns\TextInputColumn::make('smp_b_inggris_pppk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('B. Inggris PPPK'),
                Tables\Columns\TextInputColumn::make('smp_b_inggris_gtt')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('B. Inggris GTT'),
                Tables\Columns\TextColumn::make('smp_b_inggris_jumlah')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_b_inggris_selisih')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_bk_abk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('BK ABK'),
                Tables\Columns\TextInputColumn::make('smp_bk_pns')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('BK PNS'),
                Tables\Columns\TextInputColumn::make('smp_bk_pppk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('BK PPPK'),
                Tables\Columns\TextInputColumn::make('smp_bk_gtt')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('BK GTT'),
                Tables\Columns\TextColumn::make('smp_bk_jumlah')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_bk_selisih')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_ipa_abk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('IPA ABK'),
                Tables\Columns\TextInputColumn::make('smp_ipa_pns')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('IPA PNS'),
                Tables\Columns\TextInputColumn::make('smp_ipa_pppk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('IPA PPPK'),
                Tables\Columns\TextInputColumn::make('smp_ipa_gtt')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('IPA GTT'),
                Tables\Columns\TextColumn::make('smp_ipa_jumlah')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_ipa_selisih')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_ips_abk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('IPS ABK'),
                Tables\Columns\TextInputColumn::make('smp_ips_pns')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('IPS PNS'),
                Tables\Columns\TextInputColumn::make('smp_ips_pppk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('IPS PPPK'),
                Tables\Columns\TextInputColumn::make('smp_ips_gtt')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('IPS GTT'),
                Tables\Columns\TextColumn::make('smp_ips_jumlah')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_ips_selisih')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_matematika_abk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Matematika ABK'),
                Tables\Columns\TextInputColumn::make('smp_matematika_pns')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Matematika PNS'),
                Tables\Columns\TextInputColumn::make('smp_matematika_pppk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Matematika PPPK'),
                Tables\Columns\TextInputColumn::make('smp_matematika_gtt')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Matematika GTT'),
                Tables\Columns\TextColumn::make('smp_matematika_jumlah')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_matematika_selisih')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_pppkn_abk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('PPPKN ABK'),
                Tables\Columns\TextInputColumn::make('smp_pppkn_pns')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('PPPKN PNS'),
                Tables\Columns\TextInputColumn::make('smp_pppkn_pppk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('PPPKN PPPK'),
                Tables\Columns\TextInputColumn::make('smp_pppkn_gtt')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('PPPKN GTT'),
                Tables\Columns\TextColumn::make('smp_pppkn_jumlah')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_pppkn_selisih')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_prakarya_abk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Prakarya ABK'),
                Tables\Columns\TextInputColumn::make('smp_prakarya_pns')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Prakarya PNS'),
                Tables\Columns\TextInputColumn::make('smp_prakarya_pppk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Prakarya PPPK'),
                Tables\Columns\TextInputColumn::make('smp_prakarya_gtt')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Prakarya GTT'),
                Tables\Columns\TextColumn::make('smp_prakarya_jumlah')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_prakarya_selisih')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_seni_budaya_abk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Seni Budaya ABK'),
                Tables\Columns\TextInputColumn::make('smp_seni_budaya_pns')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Seni Budaya PNS'),
                Tables\Columns\TextInputColumn::make('smp_seni_budaya_pppk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Seni Budaya PPPK'),
                Tables\Columns\TextInputColumn::make('smp_seni_budaya_gtt')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Seni Budaya GTT'),
                Tables\Columns\TextColumn::make('smp_seni_budaya_jumlah')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_seni_budaya_selisih')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_b_sunda_abk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('B. Sunda ABK'),
                Tables\Columns\TextInputColumn::make('smp_b_sunda_pns')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('B. Sunda PNS'),
                Tables\Columns\TextInputColumn::make('smp_b_sunda_pppk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('B. Sunda PPPK'),
                Tables\Columns\TextInputColumn::make('smp_b_sunda_gtt')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('B. Sunda GTT'),
                Tables\Columns\TextColumn::make('smp_b_sunda_jumlah')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_b_sunda_selisih')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_tik_abk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('TIK ABK'),
                Tables\Columns\TextInputColumn::make('smp_tik_pns')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('TIK PNS'),
                Tables\Columns\TextInputColumn::make('smp_tik_pppk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('TIK PPPK'),
                Tables\Columns\TextInputColumn::make('smp_tik_gtt')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('TIK GTT'),
                Tables\Columns\TextColumn::make('smp_tik_jumlah')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_tik_selisih')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Selisih'),

                Tables\Columns\TextColumn::make('sd_jumlah_abk')
                    ->visible(function (){
                        return in_array(request()->query('activeTab'), ['','01hmmgv93qdr4j7qpaba7dapw4']);
                    })
                    ->label('Jumlah ABK SD'),
                Tables\Columns\TextColumn::make('sd_jumlah_formasi')
                    ->visible(function (){
                        return in_array(request()->query('activeTab'), ['','01hmmgv93qdr4j7qpaba7dapw4']);
                    })
                    ->label('Jumlah Formasi SD'),
                Tables\Columns\TextColumn::make('sd_jumlah_selisih')
                    ->visible(function (){
                        return in_array(request()->query('activeTab'), ['','01hmmgv93qdr4j7qpaba7dapw4']);
                    })
                    ->label('Jumlah Selisih SD'),

                Tables\Columns\TextColumn::make('smp_jumlah_abk')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Jumlah ABK SMP'),
                Tables\Columns\TextColumn::make('smp_jumlah_formasi')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Jumlah Formasi SMP'),
                Tables\Columns\TextColumn::make('smp_jumlah_selisih')
                    ->visible(function (){
                        return request()->query('activeTab') == '01hmmgv94jmmgyf7edgy5dbyjs';
                    })
                    ->label('Jumlah Selisih SMP'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenjang_sekolah')
                    ->relationship('jenjangSekolah', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Jenjang Sekolah'),
                Tables\Filters\SelectFilter::make('wilayah_kode')
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
