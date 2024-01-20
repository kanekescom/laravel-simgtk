<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Forms\Components\Tabs;
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
use Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Pages;
use Kanekescom\Simgtk\Models\BidangStudiPendidikan;
use Kanekescom\Simgtk\Models\BidangStudiSertifikasi;
use Kanekescom\Simgtk\Models\JenisPtk;
use Kanekescom\Simgtk\Models\MataPelajaran;
use Kanekescom\Simgtk\Models\Pegawai;
use Kanekescom\Simgtk\Models\Sekolah;
use Spatie\LaravelOptions\Options;

class PegawaiResource extends Resource
{
    protected static ?string $slug = 'pegawai';

    protected static ?string $pluralLabel = 'Pegawai';

    protected static ?string $model = Pegawai::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pegawai';

    protected static ?string $navigationGroup = null;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)
                    ->schema([
                        Tabs::make('Tabs')
                            ->tabs([
                                Tabs\Tab::make('Profil')
                                    ->schema([
                                        Forms\Components\TextInput::make('nama')
                                            ->maxLength(255)
                                            ->required()
                                            ->label('Nama'),
                                        Forms\Components\TextInput::make('nik')
                                            ->numeric()
                                            ->length(16)
                                            ->unique(ignoreRecord: true)
                                            ->required()
                                            ->label('NIK'),
                                        Forms\Components\TextInput::make('nuptk')
                                            ->numeric()
                                            ->length(16)
                                            ->unique(ignoreRecord: true)
                                            ->label('NUPTK'),
                                        Forms\Components\TextInput::make('nip')
                                            ->numeric()
                                            ->length(18)
                                            ->unique(ignoreRecord: true)
                                            ->label('NIP'),
                                        Forms\Components\Select::make('gender_kode')
                                            ->options(GenderEnum::class)
                                            ->in(collect(
                                                Options::forEnum(GenderEnum::class)->toArray()
                                            )->pluck('value'))
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->label('Gender'),
                                        Forms\Components\TextInput::make('tempat_lahir')
                                            ->maxLength(255)
                                            ->required()
                                            ->label('Tempat Lahir'),
                                        Forms\Components\DatePicker::make('tanggal_lahir')
                                            ->date()
                                            ->required()
                                            ->label('Tanggal Lahir'),
                                        Forms\Components\TextInput::make('gelar_depan')
                                            ->maxLength(255)
                                            ->label('Gelar Depan'),
                                        Forms\Components\TextInput::make('gelar_belakang')
                                            ->maxLength(255)
                                            ->label('Gelar Belakang'),
                                        Forms\Components\TextInput::make('nomor_hp')
                                            ->tel()
                                            ->label('Nomor HP'),
                                        Forms\Components\TextInput::make('email')
                                            ->email()
                                            ->label('Email'),
                                        Forms\Components\Select::make('jenjang_pendidikan_kode')
                                            ->options(JenjangPendidikanEnum::class)
                                            ->in(collect(
                                                Options::forEnum(JenjangPendidikanEnum::class)->toArray()
                                            )->pluck('value'))
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->label('Jenjang Pendidikan'),
                                    ]),
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
                                            ->label('Status Kepegawaian'),
                                        Forms\Components\TextInput::make('masa_kerja_tahun')
                                            ->numeric()
                                            ->minValue(0)
                                            ->maxValue(50)
                                            ->label('Masa Kerja Tahun'),
                                        Forms\Components\TextInput::make('masa_kerja_bulan')
                                            ->numeric()
                                            ->minValue(0)
                                            ->maxValue(12)
                                            ->label('Masa Kerja Bulan'),
                                        Forms\Components\DatePicker::make('tmt_cpns')
                                            ->date()
                                            ->label('TMT CPNS'),
                                        Forms\Components\DatePicker::make('tanggal_sk_cpns')
                                            ->date()
                                            ->label('Tanggal SK CPNS'),
                                        Forms\Components\TextInput::make('nomor_sk_cpns')
                                            ->maxLength(255)
                                            ->label('Nomor SK CPNS'),
                                        Forms\Components\DatePicker::make('tmt_pns')
                                            ->date()
                                            ->label('TMT PNS'),
                                        Forms\Components\DatePicker::make('tanggal_sk_pns')
                                            ->date()
                                            ->label('Tanggal SK PNS'),
                                        Forms\Components\TextInput::make('nomor_sk_pns')
                                            ->maxLength(255)
                                            ->label('Nomor SK PNS'),
                                        Forms\Components\Select::make('golongan_kode')
                                            ->options(GolonganAsnEnum::class)
                                            ->in(collect(
                                                Options::forEnum(GolonganAsnEnum::class)->toArray()
                                            )->pluck('value'))
                                            ->searchable()
                                            ->preload()
                                            ->label('Golongan'),
                                        Forms\Components\DatePicker::make('tmt_pangkat')
                                            ->date()
                                            ->label('TMT Pangkat'),
                                        Forms\Components\DatePicker::make('tanggal_sk_pangkat')
                                            ->date()
                                            ->label('Tanggal SK Pangkat'),
                                        Forms\Components\TextInput::make('nomor_sk_pangkat')
                                            ->maxLength(255)
                                            ->label('Nomor SK Pangkat'),
                                        Forms\Components\DatePicker::make('tmt_pensiun')
                                            ->date()
                                            ->label('TMT Pensiun'),
                                        Forms\Components\DatePicker::make('tanggal_sk_pensiun')
                                            ->date()
                                            ->label('Tanggal SK Pensiun'),
                                        Forms\Components\TextInput::make('nomor_sk_pensiun')
                                            ->maxLength(255)
                                            ->label('Nomor SK Pensiun'),
                                    ]),
                                Tabs\Tab::make('Jabatan')
                                    ->schema([
                                        Forms\Components\Select::make('sekolah_id')
                                            ->relationship('sekolah', 'nama')
                                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nama_wilayah}")
                                            ->exists(table: Sekolah::class, column: 'id')
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->label('Sekolah'),
                                        Forms\Components\Select::make('status_tugas_kode')
                                            ->options(StatusTugasEnum::class)
                                            ->in(collect(
                                                Options::forEnum(StatusTugasEnum::class)->toArray()
                                            )->pluck('value'))
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->label('Status Tugas'),
                                        Forms\Components\Select::make('jenis_ptk_id')
                                            ->relationship('jenisPtk', 'nama')
                                            ->exists(table: JenisPtk::class, column: 'id')
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->label('Jenis PTK'),
                                        Forms\Components\Select::make('bidang_studi_pendidikan_id')
                                            ->relationship('bidangStudiPendidikan', 'nama')
                                            ->exists(table: BidangStudiPendidikan::class, column: 'id')
                                            ->searchable()
                                            ->preload()
                                            ->label('Bidang Studi Pendidikan'),
                                        Forms\Components\Select::make('bidang_studi_sertifikasi_id')
                                            ->relationship('bidangStudiSertifikasi', 'nama')
                                            ->exists(table: BidangStudiSertifikasi::class, column: 'id')
                                            ->searchable()
                                            ->preload()
                                            ->label('Bidang Studi Sertifikasi'),
                                        Forms\Components\Select::make('mata_pelajaran_id')
                                            ->relationship('mataPelajaran', 'nama')
                                            ->exists(table: MataPelajaran::class, column: 'id')
                                            ->searchable()
                                            ->preload()
                                            ->label('Mata Pelajaran'),
                                        Forms\Components\TextInput::make('jam_mengajar_perminggu')
                                            ->numeric()
                                            ->minValue(0)
                                            ->maxValue(50)
                                            ->label('Jam Mengajar Perminggu'),
                                        Forms\Components\Toggle::make('is_kepsek')
                                            ->label('Kepsek'),
                                    ]),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_gelar')
                    ->description(fn (Pegawai $record): string => $record->nama_id)
                    ->searchable(['nama', 'nip', 'nik', 'nuptk'])
                    ->sortable(['nama'])
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('status_kepegawaian_kode')
                    ->description(fn (Pegawai $record): string => $record->gender_kode->getLabel())
                    ->sortable()
                    ->label('Status'),
                Tables\Columns\TextColumn::make('golongan_kode')
                    ->wrap()
                    ->sortable()
                    ->label('Gol/Pangkat'),
                Tables\Columns\TextColumn::make('mataPelajaran.nama')
                    ->description(fn (Pegawai $record): string => $record->sekolah?->nama)
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
                    ->label('Gol/Pangkat'),
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
            'index' => Pages\ListPegawai::route('/'),
            'create' => Pages\CreatePegawai::route('/create'),
            'edit' => Pages\EditPegawai::route('/{record}/edit'),
        ];
    }
}
