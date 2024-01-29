<?php

namespace Kanekescom\Simgtk\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kanekescom\Simgtk\Enums\StatusKepegawaianEnum;

class Sekolah extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $guarded = [];

    public function getTable()
    {
        return config('simgtk.table_prefix') . 'sekolah';
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

    public function pegawaiStatusKepegawaianPns(): HasMany
    {
        return $this->pegawai()->where('status_kepegawaian_kode', StatusKepegawaianEnum::PNS);
    }

    public function pegawaiStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawai()->where('status_kepegawaian_kode', StatusKepegawaianEnum::PPPK);
    }

    public function pegawaiStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawai()->where('status_kepegawaian_kode', StatusKepegawaianEnum::NONASN);
    }

    public function mataPelajaran(): HasManyThrough
    {
        return $this->hasManyThrough(
            MataPelajaran::class,
            Pegawai::class,
            'sekolah_id',
            'id',
            'id',
            'mata_pelajaran_id',
        );
    }

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function scopeCountByJenjangSekolah($query)
    {
        return $query
            ->select('jenjang_sekolah_id', \DB::raw('COUNT(*) as count'))
            ->with('jenjangSekolah')
            ->groupBy('jenjang_sekolah_id');
    }

    public function scopeCountByWilayah($query)
    {
        return $query
            ->select('wilayah_id', \DB::raw('COUNT(*) as count'))
            ->with('wilayah')
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
