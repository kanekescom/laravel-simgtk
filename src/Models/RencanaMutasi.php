<?php

namespace Kanekescom\Simgtk\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class RencanaMutasi extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $guarded = [];

    public function getTable()
    {
        return config('simgtk.table_prefix').'rencana_mutasi';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $is_aktif = self::where('is_aktif', true);

            if ($is_aktif->count() > 0 && $model->is_aktif == true) {
                $is_aktif->update(['is_aktif' => false]);
            }

            $pegawai = Pegawai::select('id AS pegawai_id')
                ->aktif()
                ->get()
                ->toArray();

            $model->rancangan()
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

    public function rancangan(): HasMany
    {
        return $this->hasMany(RancanganMutasi::class);
    }

    public function pegawai(): HasManyThrough
    {
        return $this->hasManyThrough(
            Pegawai::class,
            RancanganMutasi::class,
            'rencana_mutasi_id',
            'id',
            'id',
            'pegawai_id',
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

    public function usul(): HasMany
    {
        return $this->hasMany(UsulMutasi::class, 'rencana_mutasi_id');
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
