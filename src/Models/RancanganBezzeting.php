<?php

namespace Kanekescom\Simgtk\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RancanganBezzeting extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $guarded = [];

    public function getTable()
    {
        return config('simgtk.table_prefix') . 'rancangan_bezzeting';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->jumlah_kelas = $model->sekolah?->jumlah_kelas;
            $model->jumlah_rombel = $model->sekolah?->jumlah_rombel;
            $model->jumlah_siswa = $model->sekolah?->jumlah_siswa;
        });
    }

    public function rencana(): BelongsTo
    {
        return $this->belongsTo(RencanaBezzeting::class, 'rencana_bezzeting_id');
    }

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function scopeAktif($query)
    {
        return $query
            ->withWhereHas('rencana', function ($query) {
                $query->where('is_aktif', true);
            });
    }
}
