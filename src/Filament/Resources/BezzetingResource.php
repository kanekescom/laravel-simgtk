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
                    ->label('Kelas ABK'),
                Tables\Columns\TextInputColumn::make('sd_kelas_pns')
                    ->label('Kelas PNS'),
                Tables\Columns\TextInputColumn::make('sd_kelas_pppk')
                    ->label('Kelas PPPK'),
                Tables\Columns\TextInputColumn::make('sd_kelas_gtt')
                    ->label('Kelas GTT'),
                Tables\Columns\TextColumn::make('sd_kelas_jumlah')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('sd_kelas_selisih')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('sd_penjaskes_abk')
                    ->label('Penjaskes ABK'),
                Tables\Columns\TextInputColumn::make('sd_penjaskes_pns')
                    ->label('Penjaskes PNS'),
                Tables\Columns\TextInputColumn::make('sd_penjaskes_pppk')
                    ->label('Penjaskes PPPK'),
                Tables\Columns\TextInputColumn::make('sd_penjaskes_gtt')
                    ->label('Penjaskes GTT'),
                Tables\Columns\TextColumn::make('sd_penjaskes_jumlah')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('sd_penjaskes_selisih')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('sd_agama_abk')
                    ->label('Agama ABK'),
                Tables\Columns\TextInputColumn::make('sd_agama_pns')
                    ->label('Agama PNS'),
                Tables\Columns\TextInputColumn::make('sd_agama_pppk')
                    ->label('Agama PPPK'),
                Tables\Columns\TextInputColumn::make('sd_agama_gtt')
                    ->label('Agama GTT'),
                Tables\Columns\TextColumn::make('sd_agama_jumlah')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('sd_agama_selisih')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_pai_abk')
                    ->label('PAI ABK'),
                Tables\Columns\TextInputColumn::make('smp_pai_pns')
                    ->label('PAI PNS'),
                Tables\Columns\TextInputColumn::make('smp_pai_pppk')
                    ->label('PAI PPPK'),
                Tables\Columns\TextInputColumn::make('smp_pai_gtt')
                    ->label('PAI GTT'),
                Tables\Columns\TextColumn::make('smp_pai_jumlah')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_pai_selisih')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_pjok_abk')
                    ->label('PJOK ABK'),
                Tables\Columns\TextInputColumn::make('smp_pjok_pns')
                    ->label('PJOK PNS'),
                Tables\Columns\TextInputColumn::make('smp_pjok_pppk')
                    ->label('PJOK PPPK'),
                Tables\Columns\TextInputColumn::make('smp_pjok_gtt')
                    ->label('PJOK GTT'),
                Tables\Columns\TextColumn::make('smp_pjok_jumlah')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_pjok_selisih')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_b_indonesia_abk')
                    ->label('B. Indonesia ABK'),
                Tables\Columns\TextInputColumn::make('smp_b_indonesia_pns')
                    ->label('B. Indonesia PNS'),
                Tables\Columns\TextInputColumn::make('smp_b_indonesia_pppk')
                    ->label('B. Indonesia PPPK'),
                Tables\Columns\TextInputColumn::make('smp_b_indonesia_gtt')
                    ->label('B. Indonesia GTT'),
                Tables\Columns\TextColumn::make('smp_b_indonesia_jumlah')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_b_indonesia_selisih')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_b_inggris_abk')
                    ->label('B. Inggris ABK'),
                Tables\Columns\TextInputColumn::make('smp_b_inggris_pns')
                    ->label('B. Inggris PNS'),
                Tables\Columns\TextInputColumn::make('smp_b_inggris_pppk')
                    ->label('B. Inggris PPPK'),
                Tables\Columns\TextInputColumn::make('smp_b_inggris_gtt')
                    ->label('B. Inggris GTT'),
                Tables\Columns\TextColumn::make('smp_b_inggris_jumlah')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_b_inggris_selisih')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_bk_abk')
                    ->label('BK ABK'),
                Tables\Columns\TextInputColumn::make('smp_bk_pns')
                    ->label('BK PNS'),
                Tables\Columns\TextInputColumn::make('smp_bk_pppk')
                    ->label('BK PPPK'),
                Tables\Columns\TextInputColumn::make('smp_bk_gtt')
                    ->label('BK GTT'),
                Tables\Columns\TextColumn::make('smp_bk_jumlah')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_bk_selisih')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_ipa_abk')
                    ->label('IPA ABK'),
                Tables\Columns\TextInputColumn::make('smp_ipa_pns')
                    ->label('IPA PNS'),
                Tables\Columns\TextInputColumn::make('smp_ipa_pppk')
                    ->label('IPA PPPK'),
                Tables\Columns\TextInputColumn::make('smp_ipa_gtt')
                    ->label('IPA GTT'),
                Tables\Columns\TextColumn::make('smp_ipa_jumlah')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_ipa_selisih')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_ips_abk')
                    ->label('IPS ABK'),
                Tables\Columns\TextInputColumn::make('smp_ips_pns')
                    ->label('IPS PNS'),
                Tables\Columns\TextInputColumn::make('smp_ips_pppk')
                    ->label('IPS PPPK'),
                Tables\Columns\TextInputColumn::make('smp_ips_gtt')
                    ->label('IPS GTT'),
                Tables\Columns\TextColumn::make('smp_ips_jumlah')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_ips_selisih')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_matematika_abk')
                    ->label('Matematika ABK'),
                Tables\Columns\TextInputColumn::make('smp_matematika_pns')
                    ->label('Matematika PNS'),
                Tables\Columns\TextInputColumn::make('smp_matematika_pppk')
                    ->label('Matematika PPPK'),
                Tables\Columns\TextInputColumn::make('smp_matematika_gtt')
                    ->label('Matematika GTT'),
                Tables\Columns\TextColumn::make('smp_matematika_jumlah')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_matematika_selisih')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_pppkn_abk')
                    ->label('PPPKN ABK'),
                Tables\Columns\TextInputColumn::make('smp_pppkn_pns')
                    ->label('PPPKN PNS'),
                Tables\Columns\TextInputColumn::make('smp_pppkn_pppk')
                    ->label('PPPKN PPPK'),
                Tables\Columns\TextInputColumn::make('smp_pppkn_gtt')
                    ->label('PPPKN GTT'),
                Tables\Columns\TextColumn::make('smp_pppkn_jumlah')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_pppkn_selisih')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_prakarya_abk')
                    ->label('Prakarya ABK'),
                Tables\Columns\TextInputColumn::make('smp_prakarya_pns')
                    ->label('Prakarya PNS'),
                Tables\Columns\TextInputColumn::make('smp_prakarya_pppk')
                    ->label('Prakarya PPPK'),
                Tables\Columns\TextInputColumn::make('smp_prakarya_gtt')
                    ->label('Prakarya GTT'),
                Tables\Columns\TextColumn::make('smp_prakarya_jumlah')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_prakarya_selisih')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_seni_budaya_abk')
                    ->label('Seni Budaya ABK'),
                Tables\Columns\TextInputColumn::make('smp_seni_budaya_pns')
                    ->label('Seni Budaya PNS'),
                Tables\Columns\TextInputColumn::make('smp_seni_budaya_pppk')
                    ->label('Seni Budaya PPPK'),
                Tables\Columns\TextInputColumn::make('smp_seni_budaya_gtt')
                    ->label('Seni Budaya GTT'),
                Tables\Columns\TextColumn::make('smp_seni_budaya_jumlah')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_seni_budaya_selisih')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_b_sunda_abk')
                    ->label('B. Sunda ABK'),
                Tables\Columns\TextInputColumn::make('smp_b_sunda_pns')
                    ->label('B. Sunda PNS'),
                Tables\Columns\TextInputColumn::make('smp_b_sunda_pppk')
                    ->label('B. Sunda PPPK'),
                Tables\Columns\TextInputColumn::make('smp_b_sunda_gtt')
                    ->label('B. Sunda GTT'),
                Tables\Columns\TextColumn::make('smp_b_sunda_jumlah')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_b_sunda_selisih')
                    ->label('Selisih'),

                Tables\Columns\TextInputColumn::make('smp_tik_abk')
                    ->label('TIK ABK'),
                Tables\Columns\TextInputColumn::make('smp_tik_pns')
                    ->label('TIK PNS'),
                Tables\Columns\TextInputColumn::make('smp_tik_pppk')
                    ->label('TIK PPPK'),
                Tables\Columns\TextInputColumn::make('smp_tik_gtt')
                    ->label('TIK GTT'),
                Tables\Columns\TextColumn::make('smp_tik_jumlah')
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('smp_tik_selisih')
                    ->label('Selisih'),

                Tables\Columns\TextColumn::make('sd_jumlah_abk')
                    ->label('Jumlah ABK SD'),
                Tables\Columns\TextColumn::make('sd_jumlah_formasi')
                    ->label('Jumlah Formasi SD'),
                Tables\Columns\TextColumn::make('sd_jumlah_selisih')
                    ->label('Jumlah Selisih SD'),

                Tables\Columns\TextColumn::make('smp_jumlah_abk')
                    ->label('Jumlah ABK SMP'),
                Tables\Columns\TextColumn::make('smp_jumlah_formasi')
                    ->label('Jumlah Formasi SMP'),
                Tables\Columns\TextColumn::make('smp_jumlah_selisih')
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
