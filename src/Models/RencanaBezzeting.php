<?php

namespace Kanekescom\Simgtk\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class RencanaBezzeting extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $guarded = [];

    public function getTable()
    {
        return config('simgtk.table_prefix') . 'rencana_bezzeting';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $is_aktif = self::where('is_aktif', true);

            if ($is_aktif->count() > 0 && $model->is_aktif == true) {
                $is_aktif->update(['is_aktif' => false]);
            }

            $sekolah = Sekolah::get()
                ->transform(function ($sekolah) {
                    $sekolah['sekolah_id'] = $sekolah['id'];
                    unset($sekolah['id']);
                    return $sekolah;
                })
                ->toArray();

            $model->bezzeting()
                ->createMany($sekolah);

            $pegawai = Pegawai::get()
                ->transform(function ($pegawai) {
                    $pegawai['pegawai_id'] = $pegawai['id'];
                    unset($pegawai['id']);
                    return $pegawai;
                })
                ->toArray();

            $model->pegawai()
                ->createMany($pegawai);
        });

        static::updating(function ($model) {
            $is_aktif = self::where('is_aktif', true)->whereNot('id', $model->id);

            if ($is_aktif->count() > 0 && $model->is_aktif == true) {
                $is_aktif->update(['is_aktif' => false]);
            }
        });
    }

    public function getNamaPeriodeAttribute()
    {
        return "{$this->nama} ({$this->periode_tanggal})";
    }

    public function getPeriodeTanggalAttribute()
    {
        return "{$this->tanggal_mulai} - {$this->tanggal_berakhir}";
    }

    public function bezzeting(): HasMany
    {
        return $this->hasMany(RancanganBezzeting::class);
    }

    public function pegawai(): HasMany
    {
        return $this->hasMany(RancanganBezzetingPegawai::class);
    }

    public function sekolah(): HasManyThrough
    {
        return $this->hasManyThrough(
            Sekolah::class,
            RancanganBezzeting::class,
            'rencana_bezzeting_id',
            'id',
            'id',
            'sekolah_id',
        );
    }

    public function scopeAktif($query)
    {
        return $query
            ->where('is_aktif', true);
    }

    public function scopePeriodeAktif($query)
    {
        $today = now();

        return $query
            ->where('tanggal_mulai', '<=', $today)
            ->where('tanggal_berakhir', '>=', $today)
            ->where('is_aktif', true);
    }
}
