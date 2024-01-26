<?php

namespace Kanekescom\Simgtk\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function pegawai(): HasMany
    {
        return $this->hasMany(Pegawai::class);
    }

    public function scopeAktif($query)
    {
        $today = now();

        return $query
            ->where('tanggal_mulai', '<=', $today)
            ->where('tanggal_berakhir', '>=', $today)
            ->where('is_aktif', false);
    }
}
