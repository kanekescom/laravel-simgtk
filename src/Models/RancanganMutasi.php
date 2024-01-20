<?php

namespace Kanekescom\Simgtk\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function getNamaTanggalAttribute()
    {
        return "{$this->nama} ({$this->periode_tanggal})";
    }

    public function getPeriodeTanggalAttribute()
    {
        return "{$this->tanggal_mulai} - {$this->tanggal_berakhir}";
    }

    public function scopeAktif($query)
    {
        $today = now();

        return $query
            ->where('tanggal_mulai', '<=', $today)
            ->where('tanggal_berakhir', '>=', $today)
            ->where('is_selesai', false);
    }
}
