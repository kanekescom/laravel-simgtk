<?php

namespace Kanekescom\Simgtk\Filament\Traits;

use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kanekescom\Simgtk\Enums\GenderEnum;
use Kanekescom\Simgtk\Enums\GolonganAsnEnum;
use Kanekescom\Simgtk\Enums\StatusKepegawaianEnum;
use Kanekescom\Simgtk\Enums\StatusTugasEnum;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

trait HasPegawaiResource
{
    public static function defaultTable(Table $table): Table
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
                self::defaultExportBulkAction(),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function defaultExportBulkAction()
    {
        return ExportBulkAction::make()->exports([
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
        ])->visible(auth()->user()->can('export_'.self::class));
    }
}
