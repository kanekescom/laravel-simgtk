<?php

namespace Kanekescom\Simgtk\Filament\Resources\UsulMutasiResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Kanekescom\Simgtk\Filament\Resources\UsulMutasiResource;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\RencanaMutasi;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListUsulMutasi extends ListRecords
{
    protected static string $resource = UsulMutasiResource::class;

    protected static ?string $title = 'Usul Mutasi';

    public function getSubheading(): string | Htmlable | null
    {
        return RencanaMutasi::aktif()->first()?->nama_periode;
    }

    protected function getHeaderActions(): array
    {
        return [
            // ImportAction::make()
            //     ->fields([
            //         ImportField::make('id')->label('ID'),
            //         ImportField::make('rencana.nama')->label('Rencana'),
            //         ImportField::make('pegawai.nama')->label('Nama'),
            //         ImportField::make('pegawai.nik')->label('NIK'),
            //         ImportField::make('pegawai.nuptk')->label('NUPTK'),
            //         ImportField::make('pegawai.nip')->label('NIP'),
            //         ImportField::make('asalSekolah.nama')->label('Asal Sekolah'),
            //         ImportField::make('asalMataPelajaran.nama')->label('Asal Mapel'),
            //         ImportField::make('tujuanSekolah.nama')->label('Tujuan Sekolah'),
            //         ImportField::make('tujuanMataPelajaran.nama')->label('Tujuan Mapel'),
            //     ]),
            // ExportAction::make()
            //     ->exports([
            //         ExcelExport::make()
            //             ->withFilename(fn ($resource) => str($resource::getSlug())->replace('/', '_') . '-' . now()->format('Y-m-d'))
            //             ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
            //             ->withColumns([
            //                 Column::make('id')->heading('ID'),
            //                 Column::make('rencana.nama')->heading('Rencana'),
            //                 Column::make('pegawai.nama')->heading('Nama'),
            //                 Column::make('pegawai.nik')->heading('NIK'),
            //                 Column::make('pegawai.nuptk')->heading('NUPTK'),
            //                 Column::make('pegawai.nip')->heading('NIP'),
            //                 Column::make('asalSekolah.nama')->heading('Asal Sekolah'),
            //                 Column::make('asalMataPelajaran.nama')->heading('Asal Mapel'),
            //                 Column::make('tujuanSekolah.nama')->heading('Tujuan Sekolah'),
            //                 Column::make('tujuanMataPelajaran.nama')->heading('Tujuan Mapel'),
            //             ])
            //             ->ignoreFormatting(),
            //     ])->icon(false),
            Actions\CreateAction::make(),
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

        $jenjangSekolahs = JenjangSekolah::all();

        foreach ($jenjangSekolahs as $jenjangSekolah) {
            $tabs[$jenjangSekolah->id] = Tab::make($jenjangSekolah->id)
                ->badge(
                    $this->getModel()::query()
                        ->aktif()
                        ->tujuanJenjangSekolah($jenjangSekolah->id)
                        ->count()
                )
                ->modifyQueryUsing(function ($query) use ($jenjangSekolah) {
                    return $query
                        ->aktif()
                        ->tujuanJenjangSekolah($jenjangSekolah->id);
                })
                ->label($jenjangSekolah->nama);
        }

        return $tabs;
    }
}
