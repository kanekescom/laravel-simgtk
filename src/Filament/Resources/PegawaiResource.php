<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Kanekescom\Simgtk\Enums\GenderEnum;
use Kanekescom\Simgtk\Enums\GolonganAsnEnum;
use Kanekescom\Simgtk\Enums\StatusKepegawaianEnum;
use Kanekescom\Simgtk\Enums\StatusTugasEnum;
use Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Pages;
use Kanekescom\Simgtk\Models\BidangStudiPendidikan;
use Kanekescom\Simgtk\Models\BidangStudiSertifikasi;
use Kanekescom\Simgtk\Models\JenisPtk;
use Kanekescom\Simgtk\Models\JenjangPendidikan;
use Kanekescom\Simgtk\Models\MataPelajaran;
use Kanekescom\Simgtk\Models\Pegawai;
use Kanekescom\Simgtk\Models\Sekolah;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Spatie\LaravelOptions\Options;

class PegawaiResource extends Resource implements HasShieldPermissions
{
    protected static ?string $slug = 'pegawai';

    protected static ?string $pluralLabel = 'Pegawai';

    protected static ?string $model = Pegawai::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pegawai';

    protected static ?string $navigationGroup = null;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('tab_tab_profil')
                            ->label('Profil')
                            ->columns(3)
                            ->schema([
                                Forms\Components\TextInput::make('gelar_depan')
                                    ->maxLength(255)
                                    ->label('Gelar Depan'),
                                Forms\Components\TextInput::make('nama')
                                    ->maxLength(255)
                                    ->required()
                                    ->label('Nama'),
                                Forms\Components\TextInput::make('gelar_belakang')
                                    ->maxLength(255)
                                    ->label('Gelar Belakang'),
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
                                    ->in(
                                        collect(Options::forEnum(GenderEnum::class)->toArray())
                                            ->pluck('value')
                                    )
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
                                    ->live()
                                    ->required()
                                    ->label('Tanggal Lahir'),
                                Forms\Components\TextInput::make('nomor_hp')
                                    ->tel()
                                    ->label('Nomor HP'),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->label('Email'),
                                Forms\Components\Select::make('jenjang_pendidikan_id')
                                    ->relationship('jenjangPendidikan', 'nama')
                                    ->exists(table: JenjangPendidikan::class, column: 'id')
                                    ->searchable()
                                    ->preload()
                                    ->label('Jenjang Pendidikan'),
                            ]),
                        Tabs\Tab::make('tab_kepegawaian')
                            ->label('Kepegawaian')
                            ->columns(3)
                            ->schema([
                                Forms\Components\Select::make('status_kepegawaian_kode')
                                    ->options(StatusKepegawaianEnum::class)
                                    ->in(
                                        collect(Options::forEnum(StatusKepegawaianEnum::class)->toArray())
                                            ->pluck('value')
                                    )
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        if (in_array($state, [(StatusKepegawaianEnum::NONASN)->value])) {
                                            $set('nomor_sk_cpns', null);
                                            $set('tmt_cpns', null);
                                            $set('tanggal_sk_cpns', null);

                                            $set('nomor_sk_pns', null);
                                            $set('tmt_pns', null);
                                            $set('tanggal_sk_pns', null);

                                            $set('nomor_sk_pangkat', null);
                                            $set('golongan_kode', null);
                                            $set('tmt_pangkat', null);
                                            $set('tanggal_sk_pangkat', null);

                                            $set('is_kepsek', false);
                                            $set('is_plt_kepsek', false);
                                        }
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->label('Status Kepegawaian'),
                                Forms\Components\Select::make('status_kepegawaian')
                                    ->options(function () {
                                        $status_kepegawaian = Pegawai::distinct()->pluck('status_kepegawaian')->toArray();

                                        return array_combine($status_kepegawaian, $status_kepegawaian);
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->label('Status Kepegawaian Dapodik'),
                                Forms\Components\TextInput::make('masa_kerja_tahun')
                                    ->visible(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::NONASN)->value]))
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(50)
                                    ->label('Masa Kerja Tahun'),
                                Forms\Components\TextInput::make('masa_kerja_bulan')
                                    ->visible(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::NONASN)->value]))
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(12)
                                    ->label('Masa Kerja Bulan'),
                            ]),
                        Tabs\Tab::make('tab_cpns')
                            ->label('CPNS')
                            ->columns(3)
                            ->schema([
                                Forms\Components\TextInput::make('nomor_sk_cpns')
                                    ->visible(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::PNS)->value, (StatusKepegawaianEnum::PPPK)->value]))
                                    ->required(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::PNS)->value, (StatusKepegawaianEnum::PPPK)->value]))
                                    ->maxLength(255)
                                    ->label('Nomor SK CPNS'),
                                Forms\Components\DatePicker::make('tmt_cpns')
                                    ->visible(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::PNS)->value, (StatusKepegawaianEnum::PPPK)->value]))
                                    ->required(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::PNS)->value, (StatusKepegawaianEnum::PPPK)->value]))
                                    ->date()
                                    ->label('TMT CPNS'),
                                Forms\Components\DatePicker::make('tanggal_sk_cpns')
                                    ->visible(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::PNS)->value, (StatusKepegawaianEnum::PPPK)->value]))
                                    ->required(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::PNS)->value, (StatusKepegawaianEnum::PPPK)->value]))
                                    ->date()
                                    ->label('Tanggal SK CPNS'),
                            ]),
                        Tabs\Tab::make('tab_pns')
                            ->label('PNS')
                            ->columns(3)
                            ->schema([
                                Forms\Components\TextInput::make('nomor_sk_pns')
                                    ->visible(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::PNS)->value, (StatusKepegawaianEnum::PPPK)->value]))
                                    ->requiredWith(['nomor_sk_pns', 'tmt_pns', 'tanggal_sk_pns'])
                                    ->maxLength(255)
                                    ->label('Nomor SK PNS'),
                                Forms\Components\DatePicker::make('tmt_pns')
                                    ->visible(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::PNS)->value, (StatusKepegawaianEnum::PPPK)->value]))
                                    ->requiredWith(['nomor_sk_pns', 'tmt_pns', 'tanggal_sk_pns'])
                                    ->date()
                                    ->label('TMT PNS'),
                                Forms\Components\DatePicker::make('tanggal_sk_pns')
                                    ->visible(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::PNS)->value, (StatusKepegawaianEnum::PPPK)->value]))
                                    ->requiredWith(['nomor_sk_pns', 'tmt_pns', 'tanggal_sk_pns'])
                                    ->date()
                                    ->label('Tanggal SK PNS'),
                            ]),
                        Tabs\Tab::make('tab_pangkat')
                            ->label('Pangkat')
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('nomor_sk_pangkat')
                                    ->visible(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::PNS)->value, (StatusKepegawaianEnum::PPPK)->value]))
                                    // ->required(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::PNS)->value, (StatusKepegawaianEnum::PPPK)->value]))
                                    // ->requiredWith(['nomor_sk_pangkat', 'golongan_kode', 'tmt_pangkat', 'tanggal_sk_pangkat'])
                                    ->maxLength(255)
                                    ->label('Nomor SK Pangkat'),
                                Forms\Components\Select::make('golongan_kode')
                                    ->visible(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::PNS)->value, (StatusKepegawaianEnum::PPPK)->value]))
                                    ->required(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::PNS)->value, (StatusKepegawaianEnum::PPPK)->value]))
                                    ->requiredWith(['nomor_sk_pangkat', 'golongan_kode', 'tmt_pangkat', 'tanggal_sk_pangkat'])
                                    ->options(GolonganAsnEnum::class)
                                    ->in(
                                        collect(Options::forEnum(GolonganAsnEnum::class)->toArray())
                                            ->pluck('value')
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->label('Golongan'),
                                Forms\Components\DatePicker::make('tmt_pangkat')
                                    ->visible(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::PNS)->value, (StatusKepegawaianEnum::PPPK)->value]))
                                    ->required(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::PNS)->value, (StatusKepegawaianEnum::PPPK)->value]))
                                    ->requiredWith(['nomor_sk_pangkat', 'golongan_kode', 'tmt_pangkat', 'tanggal_sk_pangkat'])
                                    ->date()
                                    ->label('TMT Pangkat'),
                                Forms\Components\DatePicker::make('tanggal_sk_pangkat')
                                    ->visible(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::PNS)->value, (StatusKepegawaianEnum::PPPK)->value]))
                                    ->required(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::PNS)->value, (StatusKepegawaianEnum::PPPK)->value]))
                                    ->requiredWith(['nomor_sk_pangkat', 'golongan_kode', 'tmt_pangkat', 'tanggal_sk_pangkat'])
                                    ->date()
                                    ->label('Tanggal SK Pangkat'),
                                Forms\Components\TextInput::make('masa_kerja_tahun')
                                    ->visible(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::PNS)->value, (StatusKepegawaianEnum::PPPK)->value]))
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(50)
                                    ->label('Masa Kerja Tahun'),
                                Forms\Components\TextInput::make('masa_kerja_bulan')
                                    ->visible(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::PNS)->value, (StatusKepegawaianEnum::PPPK)->value]))
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(12)
                                    ->label('Masa Kerja Bulan'),
                            ]),
                        Tabs\Tab::make('tab_jabatan')
                            ->label('Jabatan')
                            ->columns(2)
                            ->schema([
                                Forms\Components\Select::make('sekolah_id')
                                    ->relationship('sekolah', 'nama')
                                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nama_wilayah}")
                                    ->exists(table: Sekolah::class, column: 'id')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->columnSpanFull()
                                    ->label('Sekolah'),
                                Forms\Components\Select::make('status_tugas_kode')
                                    ->options(StatusTugasEnum::class)
                                    ->in(
                                        collect(Options::forEnum(StatusTugasEnum::class)->toArray())
                                            ->pluck('value')
                                    )
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
                                    ->requiredWith(['mata_pelajaran_id', 'jam_mengajar_perminggu'])
                                    ->relationship('mataPelajaran', 'nama')
                                    ->exists(table: MataPelajaran::class, column: 'id')
                                    ->searchable()
                                    ->preload()
                                    ->label('Mata Pelajaran'),
                                Forms\Components\TextInput::make('jam_mengajar_perminggu')
                                    ->requiredWith(['mata_pelajaran_id', 'jam_mengajar_perminggu'])
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(50)
                                    ->label('Jam Mengajar Perminggu'),
                                Forms\Components\Toggle::make('is_kepsek')
                                    ->visible(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::PNS)->value, (StatusKepegawaianEnum::PPPK)->value]))
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        if ($state) {
                                            $set('is_plt_kepsek', false);
                                        }
                                    })
                                    ->label('Kepsek'),
                                Forms\Components\Toggle::make('is_plt_kepsek')
                                    ->visible(fn (Get $get) => in_array($get('status_kepegawaian_kode'), [(StatusKepegawaianEnum::PNS)->value, (StatusKepegawaianEnum::PPPK)->value]))
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        if ($state) {
                                            $set('is_kepsek', false);
                                        }
                                    })
                                    ->label('PLT Kepsek'),
                            ]),
                        Tabs\Tab::make('tab_pensiun')
                            ->label('Pensiun')
                            ->columns(3)
                            ->schema([
                                Forms\Components\DatePicker::make('tmt_pensiun')
                                    ->helperText(fn (Get $get) => 'TMT Umur 60 pada '.($get('tanggal_lahir') ? now()->parse($get('tanggal_lahir'))->addYear(60)->addMonth(1)->firstOfMonth()->toDateString() : ''))
                                    ->date()
                                    ->required()
                                    ->label('TMT Pensiun'),
                                Forms\Components\TextInput::make('nomor_sk_pensiun')
                                    ->requiredWith(['nomor_sk_pensiun', 'tanggal_sk_pensiun'])
                                    ->maxLength(255)
                                    ->label('Nomor SK Pensiun'),
                                Forms\Components\DatePicker::make('tanggal_sk_pensiun')
                                    ->requiredWith(['nomor_sk_pensiun', 'tanggal_sk_pensiun'])
                                    ->date()
                                    ->label('Tanggal SK Pensiun'),
                            ]),
                    ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->aktif())
            ->defaultSort('golongan_kode', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('#')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('nama_gelar')
                    ->description(fn (Model $record): string => $record->nama_id ?? '')
                    ->searchable(['nama', 'nip', 'nik', 'nuptk'])
                    ->sortable(['nama'])
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('status_kepegawaian_kode')
                    ->description(fn (Model $record): string => $record->gender_kode->getLabel() ?? '')
                    ->sortable()
                    ->label('Status'),
                Tables\Columns\TextColumn::make('golongan_kode')
                    ->sortable()
                    ->label('Gol'),
                Tables\Columns\TextColumn::make('sekolah.nama')
                    ->description(fn (Model $record): string => $record->mataPelajaran?->nama ?? '')
                    ->wrap()
                    ->grow()
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->whereHas('mataPelajaran', function ($query) use ($search) {
                                $query->where('nama', 'LIKE', '%'.$search.'%');
                            })
                            ->orWhereHas('sekolah', function ($query) use ($search) {
                                $query->where('nama', 'LIKE', '%'.$search.'%');
                            });
                    })
                    ->icon(fn (Model $record): string => $record->is_kepsek || $record->is_plt_kepsek ? 'heroicon-o-academic-cap' : '')
                    ->color(fn (Model $record): string => $record->is_kepsek ? 'success' : ($record->is_plt_kepsek ? 'warning' : ''))
                    ->sortable()
                    ->label('Jabatan'),
            ])
            ->filtersFormColumns(3)
            ->filters([
                Tables\Filters\SelectFilter::make('gender_kode')
                    ->options(GenderEnum::class)
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->label('Gender'),
                Tables\Filters\SelectFilter::make('jenjang_pendidikan_id')
                    ->relationship('jenjangPendidikan', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Jenjang Pendidikan'),
                Tables\Filters\SelectFilter::make('status_kepegawaian_kode')
                    ->options(StatusKepegawaianEnum::class)
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->label('Status Kepegawaian'),
                Tables\Filters\SelectFilter::make('golongan_kode')
                    ->options(GolonganAsnEnum::class)
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->label('Golongan'),
                Tables\Filters\SelectFilter::make('status_tugas_kode')
                    ->options(StatusTugasEnum::class)
                    ->multiple()
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
                    ->placeholder('All')
                    ->native(false)
                    ->label('Kepsek'),
                Tables\Filters\TernaryFilter::make('is_plt_kepsek')
                    ->placeholder('All')
                    ->native(false)
                    ->label('Plt Kepsek'),
                Tables\Filters\TernaryFilter::make('jabatan_kepsek')
                    ->queries(
                        true: fn (Builder $query) => $query->where(function (Builder $query) {
                            return $query->where('is_kepsek', true)
                                ->orWhere('is_plt_kepsek', true);
                        }),
                        false: fn (Builder $query) => $query->where(function (Builder $query) {
                            return $query->where('is_kepsek', false)
                                ->where('is_plt_kepsek', false);
                        }),
                        blank: fn (Builder $query) => $query,
                    )
                    ->placeholder('All')
                    ->native(false)
                    ->label('Jabatan Kepsek'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
                ExportBulkAction::make()->exports([
                    ExcelExport::make()->withColumns([
                        Column::make('nama')
                            ->heading('Nama'),
                        Column::make('nik')
                            ->getStateUsing(fn ($record) => ' '.$record->nik)
                            ->heading('NIK'),
                        Column::make('nuptk')
                            ->getStateUsing(fn ($record) => ' '.$record->nuptk)
                            ->heading('NUPTK'),
                        Column::make('nip')
                            ->getStateUsing(fn ($record) => ' '.$record->nip)
                            ->heading('NIP'),
                        Column::make('gender_kode')
                            ->heading('Gender'),
                        Column::make('tempat_lahir')
                            ->heading('Tempat Lahir'),
                        Column::make('tanggal_lahir')
                            ->heading('Tanggal Lahir'),
                        Column::make('gelar_depan')
                            ->heading('Gelar Depan'),
                        Column::make('gelar_belakang')
                            ->heading('Gelar Belakang'),
                        Column::make('nomor_hp')
                            ->getStateUsing(fn ($record) => (int) $record->nomor_hp)
                            ->heading('Nomor HP'),
                        Column::make('email')
                            ->heading('Email'),
                        Column::make('jenjangPendidikan.nama')
                            ->heading('Jenjang Pendidikan'),
                        Column::make('status_kepegawaian_kode')
                            ->heading('Status Kepegawaian'),
                        Column::make('masa_kerja_tahun')
                            ->heading('MK Tahun'),
                        Column::make('masa_kerja_bulan')
                            ->heading('MK Bulan'),
                        Column::make('tmt_cpns')
                            ->heading('TMT CPNS'),
                        Column::make('tanggal_sk_cpns')
                            ->heading('Tanggal SK CPNS'),
                        Column::make('nomor_sk_cpns')
                            ->heading('Nomor SK CPNS'),
                        Column::make('tmt_pns')
                            ->heading('TMT PNS'),
                        Column::make('tanggal_sk_pns')
                            ->heading('Tanggal SK PNS'),
                        Column::make('nomor_sk_pns')
                            ->heading('Nomor SK PNS'),
                        Column::make('golongan_kode')
                            ->heading('Golongan'),
                        Column::make('tmt_pangkat')
                            ->heading('TMT Pangkat'),
                        Column::make('tanggal_sk_pangkat')
                            ->heading('Tanggal SK Pangkat'),
                        Column::make('nomor_sk_pangkat')
                            ->heading('Nomor SK Pangkat'),
                        Column::make('tmt_pensiun')
                            ->heading('TMT Pensiun'),
                        Column::make('tanggal_sk_pensiun')
                            ->heading('Tanggal SK Pensiun'),
                        Column::make('nomor_sk_pensiun')
                            ->heading('Nomor SK Pensiun'),
                        Column::make('sekolah.nama')
                            ->heading('Sekolah'),
                        Column::make('sekolah.status_kode')
                            ->heading('Status Sekolah'),
                        Column::make('wilayh.nama')
                            ->heading('Wilayah'),
                        Column::make('status_tugas_kode')
                            ->heading('Status Tugas'),
                        Column::make('jenisPtk.nama')
                            ->heading('Jenis PTK'),
                        Column::make('bidangStudiPendidikan.nama')
                            ->heading('Bidang Studi Pendidikan'),
                        Column::make('bidangStudiSertifikasi.nama')
                            ->heading('Bidang Studi Sertifikasi'),
                        Column::make('mataPelajaran.nama')
                            ->heading('Mapel'),
                        Column::make('jam_mengajar_perminggu')
                            ->heading('Jam Mengajar Perminggu'),
                        Column::make('is_kepsek')
                            ->getStateUsing(fn ($record) => (int) $record->is_kepsek)
                            ->heading('Kepsek'),
                        Column::make('is_plt_kepsek')
                            ->getStateUsing(fn ($record) => (int) $record->is_plt_kepsek)
                            ->heading('Plt. Kepsek'),
                    ])->withFilename(fn ($resource) => str($resource::getSlug())->replace('/', '_').'-'.now()->format('Y-m-d')),
                ])->visible(auth()->user()->can('export_'.self::class)),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPegawai::route('/'),
            'create' => Pages\CreatePegawai::route('/create'),
            'edit' => Pages\EditPegawai::route('/{record}/edit'),
        ];
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
