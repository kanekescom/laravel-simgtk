<?php

namespace Kanekescom\Simgtk\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MataPelajaran extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $guarded = [];

    public function getTable()
    {
        return config('simgtk.table_prefix') . 'mata_pelajaran';
    }

    public function getNamaJenjangSekolahAttribute()
    {
        return "{$this->nama}, {$this->jenjangSekolah?->nama}";
    }

    public function jenjangSekolah(): BelongsTo
    {
        return $this->belongsTo(JenjangSekolah::class);
    }

    public function pegawai(): HasMany
    {
        return $this->hasMany(Pegawai::class);
    }
}
