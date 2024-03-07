<?php

namespace Kanekescom\Simgtk\Filament\Traits;

use Filament\Tables;
use Filament\Tables\Table;
use Kanekescom\Simgtk\Enums\StatusSekolahEnum;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

trait HasAbkSekolahResource
{
    public static function defaultTable(Table $table): Table
    {
        return $table
            ->defaultGroup('wilayah.nama')
            ->defaultSort('nama', 'asc')
            ->columns(self::getTableColumns())
            ->filtersFormColumns(4)
            ->filters(self::getTableFilters())
            ->bulkActions([
                ExportBulkAction::make()->exports([
                    ExcelExport::make()->withColumns(self::getExportTableColumns())
                        ->withFilename(fn ($resource) => str($resource::getSlug())->replace('/', '_').'-'.now()->format('Y-m-d')),
                ])->visible(auth()->user()->can('export_'.self::class)),
            ]);
    }

    public static function getTableColumns(): array
    {
        $columns = [];
        $columns[] = Tables\Columns\TextColumn::make('#')
            ->rowIndex();
        $columns[] = Tables\Columns\TextColumn::make('nama')
            ->wrap()
            ->grow()
            ->searchable(['nama', 'npsn'])
            ->sortable('nama')
            ->label('Nama');
        $columns[] = Tables\Columns\TextColumn::make('status_kode')
            ->sortable()
            ->label('Status');
        $columns[] = Tables\Columns\TextInputColumn::make('jumlah_kelas')
            ->rules(['required', 'digits_between:0,100'])
            ->searchable()
            ->sortable()
            ->label('Kelas');
        $columns[] = Tables\Columns\TextInputColumn::make('jumlah_rombel')
            ->rules(['required', 'digits_between:0,100'])
            ->searchable()
            ->sortable()
            ->label('Rombel');
        $columns[] = Tables\Columns\TextInputColumn::make('jumlah_siswa')
            ->rules(['required', 'digits_between:0,10000'])
            ->searchable()
            ->sortable()
            ->label('Siswa');

        foreach (self::$jenjangMapels as $jenjang_sekolah => $mapels) {
            foreach ($mapels as $mapel) {
                $columns[] = Tables\Columns\TextInputColumn::make("{$jenjang_sekolah}_{$mapel}_abk")
                    ->rules(['required', 'digits_between:0,10000'])
                    ->searchable()
                    ->sortable()
                    ->label(self::$jenjangMapelHeaders[$jenjang_sekolah][$mapel]);
            }

            $columns[] = Tables\Columns\TextColumn::make("{$jenjang_sekolah}_formasi_abk")
                ->alignEnd()
                ->searchable()
                ->sortable()
                ->label('JML');
        }

        return $columns;
    }

    public static function getTableFilters(): array
    {
        $filters = [];
        $filters[] = Tables\Filters\SelectFilter::make('status_kode')
            ->options(StatusSekolahEnum::class)
            ->multiple()
            ->searchable()
            ->preload()
            ->label('Status');
        $filters[] = Tables\Filters\SelectFilter::make('wilayah_id')
            ->relationship('wilayah', 'nama')
            ->searchable()
            ->preload()
            ->label('Wilayah');
        $filters[] = Tables\Filters\TrashedFilter::make();

        return $filters;
    }

    public static function getExportTableColumns(): array
    {
        $columns = [];
        $columns[] = Column::make('nama')
            ->heading('Nama');
        $columns[] = Column::make('status_kode')
            ->heading('Status');
        $columns[] = Column::make('jumlah_kelas')
            ->heading('Kelas');
        $columns[] = Column::make('jumlah_rombel')
            ->heading('Rombel');
        $columns[] = Column::make('jumlah_siswa')
            ->heading('Siswa');

        foreach (self::$jenjangMapels as $jenjang_sekolah => $mapels) {
            foreach ($mapels as $mapel) {
                $columns[] = Column::make("{$jenjang_sekolah}_{$mapel}_abk")
                    ->heading(self::$jenjangMapelHeaders[$jenjang_sekolah][$mapel]);
            }

            $columns[] = Column::make("{$jenjang_sekolah}_formasi_abk")
                ->heading('JML');
        }

        return $columns;
    }
}
