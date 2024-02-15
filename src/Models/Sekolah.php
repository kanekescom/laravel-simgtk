<?php

namespace Kanekescom\Simgtk\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kanekescom\Simgtk\Traits\SekolahPegawaiRelationship;

class Sekolah extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;
    use SekolahPegawaiRelationship;

    protected $guarded = [];

    public function getTable()
    {
        return config('simgtk.table_prefix') . 'sekolah';
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
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
                    $field_jenjang_sekolah_mapel_abk = "{$jenjang_sekolah}_{$mapel}_abk";

                    $field_jenjang_sekolah_mapel_abk_sum[] = $model->$field_jenjang_sekolah_mapel_abk;
                }

                $field_jenjang_sekolah_formasi_abk = "{$jenjang_sekolah}_formasi_abk";

                $model->$field_jenjang_sekolah_formasi_abk = array_sum($field_jenjang_sekolah_mapel_abk_sum);
            }
        });
    }

    public function getNamaWilayahAttribute()
    {
        return "{$this->nama}, {$this->wilayah?->nama}";
    }

    public function jenjangSekolah(): BelongsTo
    {
        return $this->belongsTo(JenjangSekolah::class);
    }

    public function pegawai(): HasMany
    {
        return $this->hasMany(Pegawai::class);
    }

    public function pegawaiAktif(): HasMany
    {
        return $this->hasMany(Pegawai::class)->aktif();
    }

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function scopeCountGroupByJenjangSekolah($query)
    {
        return $query
            ->select('jenjang_sekolah_id', \DB::raw('COUNT(*) as count'))
            ->with('jenjangSekolah')
            ->groupBy('jenjang_sekolah_id');
    }

    public function scopeCountGroupByWilayah($query, $jenjang_sekolah_id = null)
    {

        return $query
            ->select('wilayah_id', \DB::raw('COUNT(*) as count'))
            ->with('wilayah')
            ->where(function (Builder $query) use ($jenjang_sekolah_id) {
                if (filled($jenjang_sekolah_id)) {
                    return $query
                        ->where('jenjang_sekolah_id', $jenjang_sekolah_id);
                }
            })
            ->groupBy('wilayah_id');
    }

    public function scopeDefaultOrder($query)
    {
        return $query
            ->with(['wilayah' => function ($query) {
                $query->orderBy('nama', 'asc');
            }]);
    }
}
