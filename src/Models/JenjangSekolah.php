<?php

namespace Kanekescom\Simgtk\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenjangSekolah extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $guarded = [];

    public function getTable()
    {
        return config('simgtk.table_prefix') . 'jenjang_sekolah';
    }

    public function sekolah(): HasMany
    {
        return $this->hasMany(Sekolah::class);
    }

    public function mataPelajaran(): HasMany
    {
        return $this->hasMany(MataPelajaran::class);
    }
}
