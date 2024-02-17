<?php

namespace Kanekescom\Simgtk\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RancanganMutasi extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $guarded = [];

    public function getTable()
    {
        return config('simgtk.table_prefix').'rancangan_mutasi';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->asal_sekolah_id = $model->pegawai?->sekolah_id;
            $model->asal_mata_pelajaran_id = $model->pegawai?->mata_pelajaran_id;

            $model->tujuan_sekolah_id = $model->asal_sekolah_id;
            $model->tujuan_mata_pelajaran_id = $model->asal_mata_pelajaran_id;
        });
    }

    public function rencana(): BelongsTo
    {
        return $this->belongsTo(RencanaMutasi::class, 'rencana_mutasi_id');
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function asalSekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class, 'asal_sekolah_id');
    }

    public function asalMataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'asal_mata_pelajaran_id');
    }

    public function tujuanSekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class, 'tujuan_sekolah_id');
    }

    public function tujuanMataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'tujuan_mata_pelajaran_id');
    }

    public function scopeTujuanJenjangSekolah($query, $jenjang_sekolah_id)
    {
        return $query
            ->withWhereHas('tujuanSekolah', function ($query) use ($jenjang_sekolah_id) {
                $query->where('jenjang_sekolah_id', $jenjang_sekolah_id);
            });
    }

    public function scopeAktif($query)
    {
        return $query
            ->withWhereHas('rencana', function ($query) {
                $query->where('is_aktif', true);
            });
    }
}
