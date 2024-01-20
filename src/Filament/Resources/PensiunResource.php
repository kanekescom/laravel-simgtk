<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Tabs;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kanekescom\Simgtk\Enums\GenderEnum;
use Kanekescom\Simgtk\Enums\GolonganAsnEnum;
use Kanekescom\Simgtk\Enums\JenjangPendidikanEnum;
use Kanekescom\Simgtk\Enums\StatusKepegawaianEnum;
use Kanekescom\Simgtk\Enums\StatusTugasEnum;
use Kanekescom\Simgtk\Filament\Resources\PensiunResource\Pages;
use Kanekescom\Simgtk\Models\BidangStudiPendidikan;
use Kanekescom\Simgtk\Models\BidangStudiSertifikasi;
use Kanekescom\Simgtk\Models\JenisPtk;
use Kanekescom\Simgtk\Models\MataPelajaran;
use Kanekescom\Simgtk\Models\Pegawai;
use Kanekescom\Simgtk\Models\Sekolah;
use Spatie\LaravelOptions\Options;

class PensiunResource extends Resource
{
    protected static ?string $slug = 'pensiun';

    protected static ?string $pluralLabel = 'Pensiun';

    protected static ?string $model = Pegawai::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pensiun';

    protected static ?string $navigationGroup = null;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Profil')
                            ->schema([
                                Forms\Components\TextInput::make('gelar_depan')
                                    ->maxLength(255)
                                    ->disabled()
                                    ->label('Gelar Depan'),
                                Forms\Components\TextInput::make('nama')
                                    ->maxLength(255)
                                    ->required()
                                    ->disabled()
                                    ->label('Nama'),
                                Forms\Components\TextInput::make('gelar_belakang')
                                    ->maxLength(255)
                                    ->disabled()
                                    ->label('Gelar Belakang'),
                                Forms\Components\TextInput::make('nik')
                                    ->numeric()
                                    ->length(16)
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->disabled()
                                    ->label('NIK'),
                                Forms\Components\TextInput::make('nuptk')
                                    ->numeric()
                                    ->length(16)
                                    ->unique(ignoreRecord: true)
                                    ->disabled()
                                    ->label('NUPTK'),
                                Forms\Components\TextInput::make('nip')
                                    ->numeric()
                                    ->length(18)
                                    ->unique(ignoreRecord: true)
                                    ->disabled()
                                    ->label('NIP'),
                                Forms\Components\Select::make('gender_kode')
                                    ->options(GenderEnum::class)
                                    ->in(collect(
                                        Options::forEnum(GenderEnum::class)->toArray()
                                    )->pluck('value'))
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->disabled()
                                    ->label('Gender'),
                                Forms\Components\TextInput::make('tempat_lahir')
                                    ->maxLength(255)
                                    ->required()
                                    ->disabled()
                                    ->label('Tempat Lahir'),
                                Forms\Components\DatePicker::make('tanggal_lahir')
                                    ->date()
                                    ->required()
                                    ->disabled()
                                    ->label('Tanggal Lahir'),
                                Forms\Components\TextInput::make('nomor_hp')
                                    ->tel()
                                    ->disabled()
                                    ->label('Nomor HP'),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->disabled()
                                    ->label('Email'),
                                Forms\Components\Select::make('jenjang_pendidikan_kode')
                                    ->options(JenjangPendidikanEnum::class)
                                    ->in(collect(
                                        Options::forEnum(JenjangPendidikanEnum::class)->toArray()
                                    )->pluck('value'))
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->disabled()
                                    ->label('Jenjang Pendidikan'),
                            ])->columns(3),
                        Tabs\Tab::make('Kepegawaian')
                            ->schema([
                                Forms\Components\Select::make('status_kepegawaian_kode')
                                    ->options(StatusKepegawaianEnum::class)
                                    ->in(collect(
                                        Options::forEnum(StatusKepegawaianEnum::class)->toArray()
                                    )->pluck('value'))
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->disabled()
                                    ->label('Status Kepegawaian'),
                                Forms\Components\TextInput::make('masa_kerja_tahun')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(50)
                                    ->disabled()
                                    ->label('Masa Kerja Tahun'),
                                Forms\Components\TextInput::make('masa_kerja_bulan')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(12)
                                    ->disabled()
                                    ->label('Masa Kerja Bulan'),
                            ])->columns(3),
                        Tabs\Tab::make('CPNS')
                            ->schema([
                                Forms\Components\TextInput::make('nomor_sk_cpns')
                                    ->maxLength(255)
                                    ->disabled()
                                    ->label('Nomor SK CPNS'),
                                Forms\Components\DatePicker::make('tmt_cpns')
                                    ->date()
                                    ->disabled()
                                    ->label('TMT CPNS'),
                                Forms\Components\DatePicker::make('tanggal_sk_cpns')
                                    ->date()
                                    ->disabled()
                                    ->label('Tanggal SK CPNS'),
                            ])->columns(3),
                        Tabs\Tab::make('PNS')
                            ->schema([
                                Forms\Components\TextInput::make('nomor_sk_pns')
                                    ->maxLength(255)
                                    ->disabled()
                                    ->label('Nomor SK PNS'),
                                Forms\Components\DatePicker::make('tmt_pns')
                                    ->date()
                                    ->disabled()
                                    ->label('TMT PNS'),
                                Forms\Components\DatePicker::make('tanggal_sk_pns')
                                    ->date()
                                    ->disabled()
                                    ->label('Tanggal SK PNS'),
                            ])->columns(3),
                        Tabs\Tab::make('Pangkat')
                            ->schema([
                                Forms\Components\TextInput::make('nomor_sk_pangkat')
                                    ->maxLength(255)
                                    ->disabled()
                                    ->label('Nomor SK Pangkat'),
                                Forms\Components\Select::make('golongan_kode')
                                    ->options(GolonganAsnEnum::class)
                                    ->in(collect(
                                        Options::forEnum(GolonganAsnEnum::class)->toArray()
                                    )->pluck('value'))
                                    ->searchable()
                                    ->preload()
                                    ->disabled()
                                    ->label('Golongan'),
                                Forms\Components\DatePicker::make('tmt_pangkat')
                                    ->date()
                                    ->disabled()
                                    ->label('TMT Pangkat'),
                                Forms\Components\DatePicker::make('tanggal_sk_pangkat')
                                    ->date()
                                    ->disabled()
                                    ->label('Tanggal SK Pangkat'),
                            ])->columns(2),
                        Tabs\Tab::make('Jabatan')
                            ->schema([
                                Forms\Components\Select::make('sekolah_id')
                                    ->relationship('sekolah', 'nama')
                                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nama_wilayah}")
                                    ->exists(table: Sekolah::class, column: 'id')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->columnSpanFull()
                                    ->disabled()
                                    ->label('Sekolah'),
                                Forms\Components\Select::make('status_tugas_kode')
                                    ->options(StatusTugasEnum::class)
                                    ->in(collect(
                                        Options::forEnum(StatusTugasEnum::class)->toArray()
                                    )->pluck('value'))
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->disabled()
                                    ->label('Status Tugas'),
                                Forms\Components\Select::make('jenis_ptk_id')
                                    ->relationship('jenisPtk', 'nama')
                                    ->exists(table: JenisPtk::class, column: 'id')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->disabled()
                                    ->label('Jenis PTK'),
                                Forms\Components\Select::make('bidang_studi_pendidikan_id')
                                    ->relationship('bidangStudiPendidikan', 'nama')
                                    ->exists(table: BidangStudiPendidikan::class, column: 'id')
                                    ->searchable()
                                    ->preload()
                                    ->disabled()
                                    ->label('Bidang Studi Pendidikan'),
                                Forms\Components\Select::make('bidang_studi_sertifikasi_id')
                                    ->relationship('bidangStudiSertifikasi', 'nama')
                                    ->exists(table: BidangStudiSertifikasi::class, column: 'id')
                                    ->searchable()
                                    ->preload()
                                    ->disabled()
                                    ->label('Bidang Studi Sertifikasi'),
                                Forms\Components\Select::make('mata_pelajaran_id')
                                    ->relationship('mataPelajaran', 'nama')
                                    ->exists(table: MataPelajaran::class, column: 'id')
                                    ->searchable()
                                    ->preload()
                                    ->disabled()
                                    ->label('Mata Pelajaran'),
                                Forms\Components\TextInput::make('jam_mengajar_perminggu')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(50)
                                    ->disabled()
                                    ->label('Jam Mengajar Perminggu'),
                                Forms\Components\Toggle::make('is_kepsek')
                                    ->disabled()
                                    ->label('Kepsek'),
                            ])->columns(2),
                        Tabs\Tab::make('Pensiun')
                            ->schema([
                                Forms\Components\TextInput::make('nomor_sk_pensiun')
                                    ->maxLength(255)
                                    ->label('Nomor SK Pensiun'),
                                Forms\Components\DatePicker::make('tmt_pensiun')
                                    ->date()
                                    ->label('TMT Pensiun'),
                                Forms\Components\DatePicker::make('tanggal_sk_pensiun')
                                    ->date()
                                    ->label('Tanggal SK Pensiun'),
                            ])->columns(3),
                    ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_gelar')
                    ->description(fn (Pegawai $record): string => $record->nama_id ?? '')
                    ->searchable(['nama', 'nip', 'nik', 'nuptk'])
                    ->sortable(['nama'])
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('status_kepegawaian_kode')
                    ->description(fn (Pegawai $record): string => $record->gender_kode->getLabel() ?? '')
                    ->sortable()
                    ->label('Status'),
                Tables\Columns\TextColumn::make('golongan_kode')
                    ->wrap()
                    ->sortable()
                    ->label('Gol'),
                Tables\Columns\TextColumn::make('mataPelajaran.nama')
                    ->description(fn (Pegawai $record): string => $record->sekolah?->nama ?? '')
                    ->wrap()
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->whereHas('mataPelajaran', function ($query) use ($search) {
                                $query->where('nama', 'LIKE', '%' . $search . '%');
                            })
                            ->orWhereHas('sekolah', function ($query) use ($search) {
                                $query->where('nama', 'LIKE', '%' . $search . '%');
                            });
                    })
                    ->sortable()
                    ->label('Jabatan'),
                Tables\Columns\TextColumn::make('nomor_sk_pensiun')
                    ->description(fn (Pegawai $record): string => $record->tmt_pensiun ?? '')
                    ->searchable(['tmt_pensiun', 'nomor_sk_pensiun', 'tanggal_sk_pensiun'])
                    ->sortable(['tmt_pensiun'])
                    ->label('Pensiun'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gender_kode')
                    ->options(GenderEnum::class)
                    ->searchable()
                    ->preload()
                    ->label('Gender'),
                Tables\Filters\SelectFilter::make('jenjang_pendidikan_kode')
                    ->options(JenjangPendidikanEnum::class)
                    ->searchable()
                    ->preload()
                    ->label('Jenjang Pendidikan'),
                Tables\Filters\SelectFilter::make('status_kepegawaian_kode')
                    ->options(StatusKepegawaianEnum::class)
                    ->searchable()
                    ->preload()
                    ->label('Status Kepegawaian'),
                Tables\Filters\SelectFilter::make('golongan_kode')
                    ->options(GolonganAsnEnum::class)
                    ->searchable()
                    ->preload()
                    ->label('Golongan'),
                Tables\Filters\SelectFilter::make('status_tugas_kode')
                    ->options(StatusTugasEnum::class)
                    ->searchable()
                    ->preload()
                    ->label('Status Tugas'),
                Tables\Filters\SelectFilter::make('sekolah_id')
                    ->relationship('sekolah', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Sekolah'),
                Tables\Filters\SelectFilter::make('jenis_ptk_id')
                    ->relationship('jenisptk', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Jenis PTK'),
                Tables\Filters\SelectFilter::make('bidang_studi_pendidikan_id')
                    ->relationship('bidangStudiPendidikan', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Bidang Studi Pendidikan'),
                Tables\Filters\SelectFilter::make('bidang_studi_sertifikasi_id')
                    ->relationship('bidangStudiSertifikasi', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Bidang Studi Sertifikasi'),
                Tables\Filters\SelectFilter::make('mata_pelajaran_id')
                    ->relationship('mataPelajaran', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Mata Pelajaran'),
                Tables\Filters\TernaryFilter::make('is_kepsek')
                    ->label('Kepsek'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPensiun::route('/'),
            'edit' => Pages\EditPensiun::route('/{record}/edit'),
        ];
    }
}
