<?php

namespace Kanekescom\Simgtk\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MataPelajaranJenjangSekolah extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $guarded = [];

    public function getTable()
    {
        return config('simgtk.table_prefix').'mata_pelajaran_jenjang_sekolah';
    }

    public function jenjangSekolah(): HasMany
    {
        return $this->hasMany(JenjangSekolah::class);
    }

    public function mataPelajaran(): HasMany
    {
        return $this->hasMany(MataPelajaran::class);
    }
}
