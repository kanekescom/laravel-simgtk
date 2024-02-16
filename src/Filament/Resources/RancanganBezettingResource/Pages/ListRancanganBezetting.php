<?php

namespace Kanekescom\Simgtk\Filament\Resources\RancanganBezettingResource\Pages;

use Filament\Pages\Actions\Action;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Kanekescom\Simgtk\Filament\Resources\LiveBezettingResource;
use Kanekescom\Simgtk\Filament\Resources\RancanganBezettingResource;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\RencanaBezetting;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListRancanganBezetting extends ListRecords
{
    protected static string $resource = RancanganBezettingResource::class;

    protected static ?string $title = 'Bezetting';

    public function getSubheading(): string | Htmlable | null
    {
        return RencanaBezetting::aktif()->first()?->nama;
    }

    protected function getHeaderActions(): array
    {
        $exportColumns = [];
        $exportColumns[] = Column::make('id')->heading('ID');
        $exportColumns[] = Column::make('rencana.nama')->heading('Nama');
        $exportColumns[] = Column::make('rencana.tanggal_mulai')->heading('Tanggal Mulai');
        $exportColumns[] = Column::make('rencana.tanggal_berakhir')->heading('Tanggal Berakhir');
        $exportColumns[] = Column::make('nama')->heading('Sekolah');
        $exportColumns[] = Column::make('npsn')->heading('NPSN');
        $exportColumns[] = Column::make('jenjangSekolah.nama')->heading('Jenjang');
        $exportColumns[] = Column::make('wilayah.nama')->heading('Wilayah');
        $exportColumns[] = Column::make('jumlah_kelas')->heading('Kelas');
        $exportColumns[] = Column::make('jumlah_rombel')->heading('Rombel');
        $exportColumns[] = Column::make('jumlah_siswa')->heading('Siswa');

        $exportColumns[] = Column::make('pegawai_kepsek_count')->getStateUsing(fn ($record) => $record->pegawaiKepsek()->count())->heading('Kepsek');
        $exportColumns[] = Column::make('pegawai_plt_kepsek_count')->getStateUsing(fn ($record) => $record->pegawaiPltKepsek()->count())->heading('Plt');

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

        $activeTab = request()->query('activeTab');
        $jenjang_sekolah = in_array($activeTab, ['sd', 'smp']) ? $activeTab : 'sd';
        $mapels = $jenjang_mapels[$jenjang_sekolah] ?? [];

        foreach ($jenjang_mapels as $jenjang_sekolah => $mapels) {
            $relation_pegawai_jenjang_sekolah_status_kepegawaian_pns = 'pegawai' . str($jenjang_sekolah)->ucfirst() . 'StatusKepegawaianPns';
            $relation_pegawai_jenjang_sekolah_status_kepegawaian_pppk = 'pegawai' . str($jenjang_sekolah)->ucfirst() . 'StatusKepegawaianPppk';
            $relation_pegawai_jenjang_sekolah_status_kepegawaian_gtt = 'pegawai' . str($jenjang_sekolah)->ucfirst() . 'StatusKepegawaianGtt';
            $relation_pegawai_jenjang_sekolah = 'pegawai' . str($jenjang_sekolah)->ucfirst();

            $exportColumns[] = Column::make("pegawai_{$jenjang_sekolah}_status_kepegawaian_pns_count")
                ->getStateUsing(fn ($record) => $record->$relation_pegawai_jenjang_sekolah_status_kepegawaian_pns()->count())
                ->heading('PNS');
            $exportColumns[] = Column::make("pegawai_{$jenjang_sekolah}_status_kepegawaian_pppk_count")
                ->getStateUsing(fn ($record) => $record->$relation_pegawai_jenjang_sekolah_status_kepegawaian_pppk()->count())
                ->heading('PPPK');
            $exportColumns[] = Column::make("pegawai_{$jenjang_sekolah}_status_kepegawaian_gtt_count")
                ->getStateUsing(fn ($record) => $record->$relation_pegawai_jenjang_sekolah_status_kepegawaian_gtt()->count())
                ->heading('GTT');
            $exportColumns[] = Column::make("pegawai_{$jenjang_sekolah}_count")
                ->getStateUsing(fn ($record) => $record->$relation_pegawai_jenjang_sekolah()->count())
                ->heading('JML');

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

                $exportColumns[] = Column::make($field_jenjang_sekolah_mapel_abk)
                    ->heading("{$jenjang_mapel_headers[$jenjang_sekolah][$mapel]} ABK");
                $exportColumns[] = Column::make($field_jenjang_sekolah_mapel_pns)
                    ->heading("{$jenjang_mapel_headers[$jenjang_sekolah][$mapel]} PNS");
                $exportColumns[] = Column::make($field_jenjang_sekolah_mapel_pppk)
                    ->heading("{$jenjang_mapel_headers[$jenjang_sekolah][$mapel]} PPPK");
                $exportColumns[] = Column::make($field_jenjang_sekolah_mapel_gtt)
                    ->heading("{$jenjang_mapel_headers[$jenjang_sekolah][$mapel]} GTT");
                $exportColumns[] = Column::make($field_jenjang_sekolah_mapel_total)
                    ->heading('ABK');
                $exportColumns[] = Column::make($field_jenjang_sekolah_mapel_selisih)
                    ->heading('+/- ABK');
                $exportColumns[] = Column::make($field_jenjang_sekolah_mapel_existing_total)
                    ->heading('EXT');
                $exportColumns[] = Column::make($field_jenjang_sekolah_mapel_existing_selisih)
                    ->heading('+/- EXT');
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

            $exportColumns[] = Column::make($field_jenjang_sekolah_formasi_abk)
                ->heading('JML ABK');
            $exportColumns[] = Column::make($field_jenjang_sekolah_formasi_selisih)
                ->heading('+/- ABK');
            $exportColumns[] = Column::make($field_jenjang_sekolah_formasi_existing_total)
                ->heading('JML EXT');
            $exportColumns[] = Column::make($field_jenjang_sekolah_formasi_existing_selisih)
                ->heading('+/- EXT');
        }

        return [
            // ImportAction::make()
            //     ->fields([
            //         ImportField::make('id')
            //             ->rules('required|max:255')
            //             ->label('ID'),
            //         ImportField::make('rencana.nama')
            //             ->rules('required|max:255')
            //             ->label('Nama'),
            //         ImportField::make('sekolah.nama')
            //             ->rules('required|max:255')
            //             ->label('Sekolah'),
            //         ImportField::make('jenjangSekolah.nama')
            //             ->rules('required|max:255')
            //             ->label('Jenjang Sekolah'),
            //         ImportField::make('wilayah.nama')
            //             ->rules('required|max:255')
            //             ->label('Wilayah'),
            //         ImportField::make('jumlah_kelas')
            //             ->rules('required|max:255')
            //             ->label('Jumlah Kelas'),
            //         ImportField::make('jumlah_rombel')
            //             ->rules('required|max:255')
            //             ->label('Jumlah Rombel'),
            //         ImportField::make('jumlah_siswa')
            //             ->rules('required|max:255')
            //             ->label('Jumlah Siswa'),
            //     ]),
            // ExportAction::make()
            //     ->exports([
            //         ExcelExport::make()
            //             ->withFilename(fn ($resource) => str($resource::getSlug())->replace('/', '_') . '-' . now()->format('Y-m-d'))
            //             ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
            //             ->withColumns($exportColumns)
            //             ->ignoreFormatting(),
            //     ])->icon(false),
            Action::make('live-bezetting')
                ->label('Live')
                ->url(LiveBezettingResource::getSlug()),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];

        $jenjangSekolahs = JenjangSekolah::all();

        foreach ($jenjangSekolahs as $jenjangSekolah) {
            $tabs[$jenjangSekolah->kode] = Tab::make($jenjangSekolah->id)
                ->badge(
                    $this->getModel()::query()
                        ->aktif()
                        ->where('jenjang_sekolah_id', $jenjangSekolah->id)
                        ->defaultOrder()
                        ->count()
                )
                ->modifyQueryUsing(function ($query) use ($jenjangSekolah) {
                    return $query
                        ->aktif()
                        ->where('jenjang_sekolah_id', $jenjangSekolah->id)
                        ->defaultOrder();
                })
                ->label($jenjangSekolah->nama);
        }

        return $tabs;
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return JenjangSekolah::first()->kode;
    }
}
