<?php

namespace Kanekescom\Simgtk\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kanekescom\Simgtk\Enums\StatusSekolahEnum;

class RancanganBezetting extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'status_kode' => StatusSekolahEnum::class,
    ];

    public function getTable()
    {
        return config('simgtk.table_prefix').'rancangan_bezetting';
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
                    $field_jenjang_sekolah_mapel_total = "{$jenjang_sekolah}_{$mapel}_total";
                    $field_jenjang_sekolah_mapel_selisih = "{$jenjang_sekolah}_{$mapel}_selisih";

                    $model->$field_jenjang_sekolah_mapel_selisih = $model->$field_jenjang_sekolah_mapel_total - $model->$field_jenjang_sekolah_mapel_abk;

                    $field_jenjang_sekolah_mapel_existing_total = "{$jenjang_sekolah}_{$mapel}_existing_total";
                    $field_jenjang_sekolah_mapel_existing_selisih = "{$jenjang_sekolah}_{$mapel}_existing_selisih";

                    $model->$field_jenjang_sekolah_mapel_existing_selisih = $model->$field_jenjang_sekolah_mapel_existing_total - $model->$field_jenjang_sekolah_mapel_abk;
                }

                $field_jenjang_sekolah_formasi_abk = "{$jenjang_sekolah}_formasi_abk";
                $field_jenjang_sekolah_formasi_total = "{$jenjang_sekolah}_formasi_total";
                $field_jenjang_sekolah_formasi_selisih = "{$jenjang_sekolah}_formasi_selisih";

                $model->$field_jenjang_sekolah_formasi_selisih = $model->$field_jenjang_sekolah_formasi_total - $model->$field_jenjang_sekolah_formasi_abk;

                $field_jenjang_sekolah_formasi_existing_total = "{$jenjang_sekolah}_formasi_existing_total";
                $field_jenjang_sekolah_formasi_existing_selisih = "{$jenjang_sekolah}_formasi_existing_selisih";

                $model->$field_jenjang_sekolah_formasi_existing_selisih = $model->$field_jenjang_sekolah_formasi_existing_total - $model->$field_jenjang_sekolah_formasi_abk;
            }
        });
    }

    public function getNamaWilayahAttribute()
    {
        return "{$this->nama}, {$this->wilayah?->nama}";
    }

    public function rencana(): BelongsTo
    {
        return $this->belongsTo(RencanaBezetting::class, 'rencana_bezetting_id');
    }

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function jenjangSekolah(): BelongsTo
    {
        return $this->belongsTo(JenjangSekolah::class);
    }

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function pegawai(): HasManyThrough
    {
        return $this->hasManyThrough(
            RancanganBezettingPegawai::class,
            Sekolah::class,
            'id',
            'sekolah_id',
            'sekolah_id',
            'id',
        );
    }

    public function pegawaiAktif(): HasManyThrough
    {
        return $this->pegawai()->aktif();
    }

    public function guru(): HasManyThrough
    {
        return $this->pegawai()->guru();
    }

    public function guruAktif(): HasManyThrough
    {
        return $this->pegawaiAktif()->guru();
    }

    public function scopeAktif($query)
    {
        return $query
            ->whereHas('rencana', function ($query) {
                $query->where('is_aktif', true);
            });
    }

    public function scopeDefaultOrder($query)
    {
        return $query
            ->with(['wilayah' => function ($query) {
                $query->orderBy('nama', 'asc');
            }]);
    }
}
