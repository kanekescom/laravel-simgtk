<?php

namespace Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Enums\StatusKepegawaianEnum;
use Kanekescom\Simgtk\Filament\Resources\PegawaiResource;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Spatie\LaravelOptions\Options;

class ListPegawai extends ListRecords
{
    protected static string $resource = PegawaiResource::class;

    protected static ?string $title = 'Pegawai';

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->uniqueField('id')
                ->fields([
                    ImportField::make('id')
                        ->rules('required|max:255')
                        ->label('ID'),
                    ImportField::make('nik')
                        ->rules('required|length:255')
                        ->label('NIK'),
                    ImportField::make('nuptk')
                        ->rules('required|length:8')
                        ->label('NUPTK'),
                    ImportField::make('nip')
                        ->rules('required|max:255')
                        ->label('NIP'),
                    ImportField::make('gender_kode')
                        ->rules('required|max:255')
                        ->label('Gender'),
                    ImportField::make('status_kepegawaian_kode')
                        ->rules('required|max:255')
                        ->label('Status Kepegawaian'),
                    ImportField::make('golongan_kode')
                        ->rules('required|max:255')
                        ->label('Golongan'),
                ]),
            ExportAction::make()
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename(fn ($resource) => $resource::getSlug() . '-' . now()->format('Y-m-d'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                        ->withColumns([
                            Column::make('nama_gelar')->heading('Nama'),
                            Column::make('nik')->heading('NIK'),
                            Column::make('nuptk')->heading('NUPTK'),
                            Column::make('nip')->heading('NIP'),
                            Column::make('status_kepegawaian_kode')->heading('Status'),
                            Column::make('golongan_kode')->heading('Golongan'),
                            Column::make('nomor_sk_pangkat')->heading('Nomor SK Pangkat'),
                            Column::make('tmt_pangkat')->heading('TMT Pangkat'),
                            Column::make('tanggal_sk_pangkat')->heading('Tanggal SK Pangkat'),
                            Column::make('mataPelajaran.nama')->heading('Mata Pelajaran'),
                            Column::make('sekolah.nama')->heading('Sekolah'),
                            Column::make('nomor_sk_cpns')->heading('Nomor SK CPNS'),
                            Column::make('tmt_cpns')->heading('TMT CPNS'),
                            Column::make('tanggal_sk_cpns')->heading('Tanggal SK CPNS'),
                            Column::make('nomor_sk_pns')->heading('Nomor SK PNS'),
                            Column::make('tmt_pns')->heading('TMT PNS'),
                            Column::make('tanggal_sk_pns')->heading('Tanggal SK PNS'),
                            Column::make('is_kepsek')->heading('Kepsek'),
                        ])
                        ->ignoreFormatting(),
                ])->icon(false),
            Actions\CreateAction::make()->label('Create'),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];

        $tabs[''] = Tab::make('All')
            ->badge(
                $this->getModel()::query()
                    ->aktif()
                    ->count()
            );

        $statusKepegawaians = Options::forEnum(StatusKepegawaianEnum::class)->toArray();

        foreach ($statusKepegawaians as $statusKepegawaian) {
            $tabs[$statusKepegawaian['value']] = Tab::make($statusKepegawaian['value'])
                ->badge(
                    $this->getModel()::query()
                        ->aktif()
                        ->where('status_kepegawaian_kode', $statusKepegawaian['value'])
                        ->count()
                )
                ->modifyQueryUsing(function ($query) use ($statusKepegawaian) {
                    return $query
                        ->aktif()
                        ->where('status_kepegawaian_kode', $statusKepegawaian['value']);
                })
                ->label($statusKepegawaian['label']);
        }

        return $tabs;
    }
}
