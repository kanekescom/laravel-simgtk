<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Kanekescom\Simgtk\Filament\Resources\AbkSekolahResource\Pages;
use Kanekescom\Simgtk\Models\Sekolah;

class AbkSekolahResource extends Resource
{
    protected static ?string $slug = 'referensi/bezetting/abk-sekolah';

    protected static ?string $pluralLabel = 'ABK Sekolah';

    protected static ?string $model = Sekolah::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'ABK';

    protected static ?string $navigationGroup = 'Referensi Bezetting';

    public static function table(Table $table): Table
    {
        $columns = [];
        $columns[] = Tables\Columns\TextColumn::make('nama')
            ->wrap()
            ->grow()
            ->searchable(['nama', 'npsn'])
            ->sortable('nama')
            ->label('Nama');
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

        foreach ($jenjang_mapels as $jenjang_sekolah => $mapels) {
            foreach ($mapels as $mapel) {
                $columns[] = Tables\Columns\TextInputColumn::make("{$jenjang_sekolah}_{$mapel}_abk")
                    ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                    ->rules(['required', 'digits_between:0,10000'])
                    ->searchable()
                    ->sortable()
                    ->label("{$jenjang_mapel_headers[$jenjang_sekolah][$mapel]}");
            }

            $columns[] = Tables\Columns\TextColumn::make("{$jenjang_sekolah}_formasi_abk")
                ->visible(fn ($livewire) => $livewire->activeTab === $jenjang_sekolah)
                ->alignment(Alignment::End)
                ->searchable()
                ->sortable()
                ->label('JML');
        }

        return $table
            ->defaultGroup('wilayah.nama')
            ->columns($columns)
            ->filters([
                Tables\Filters\SelectFilter::make('jenjang_sekolah')
                    ->relationship('jenjangSekolah', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Jenjang Sekolah'),
                Tables\Filters\SelectFilter::make('wilayah_id')
                    ->relationship('wilayah', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Wilayah'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ])
            ->emptyStateActions([
                //
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
            'index' => Pages\ListAbkSekolah::route('/'),
        ];
    }
}
