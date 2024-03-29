<?php

namespace Kanekescom\Simgtk\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kanekescom\Simgtk\Enums\StatusSekolahEnum;
use Kanekescom\Simgtk\Traits\HasSekolahPegawaiRelationship;

class Sekolah extends Model
{
    use HasFactory;
    use HasSekolahPegawaiRelationship;
    use HasUlids;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'status_kode' => StatusSekolahEnum::class,
    ];

    public function getTable()
    {
        return config('simgtk.table_prefix').'sekolah';
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

                    $field_jenjang_sekolah_sum[$jenjang_sekolah][] = $model->$field_jenjang_sekolah_mapel_abk;
                }

                $field_jenjang_sekolah_formasi_abk = "{$jenjang_sekolah}_formasi_abk";

                $model->$field_jenjang_sekolah_formasi_abk = array_sum($field_jenjang_sekolah_sum[$jenjang_sekolah]);
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
        return $this->hasMany(Pegawai::class, 'sekolah_id', 'id');
    }

    public function pegawaiAktif(): HasMany
    {
        return $this
            ->pegawai()
            ->aktif();
    }

    public function guru(): HasMany
    {
        return $this
            ->pegawai()
            ->guru();
    }

    public function guruAktif(): HasMany
    {
        return $this
            ->pegawaiAktif()
            ->guru();
    }

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function scopeStatusNegeri($query)
    {
        return $query
            ->where('status_kode', StatusSekolahEnum::NEGERI);
    }

    public function scopeStatusSwasta($query)
    {
        return $query
            ->where('status_kode', StatusSekolahEnum::SWASTA);
    }

    public function scopeJenjangSekolahSd($query)
    {
        return $query
            ->where('jenjang_sekolah_id', JenjangSekolah::where('kode', 'sd')->first()?->id);
    }

    public function scopeJenjangSekolahSmp($query)
    {
        return $query
            ->where('jenjang_sekolah_id', JenjangSekolah::where('kode', 'smp')->first()?->id);
    }

    public function scopeCountGroupByStatus($query, $jenjang_sekolah_id = null)
    {
        return $query
            ->select('status_kode', \DB::raw('COUNT(*) as count'))
            ->where('jenjang_sekolah_id', function (Builder $query) use ($jenjang_sekolah_id) {
                if (filled($jenjang_sekolah_id)) {
                    $query->where('jenjang_sekolah_id', $jenjang_sekolah_id);
                }
            })
            ->groupBy('status_kode');
    }

    public function scopeDefaultOrder($query)
    {
        return $query
            ->with(['wilayah' => function ($query) {
                $query->orderBy('nama', 'asc');
            }]);
    }
}
