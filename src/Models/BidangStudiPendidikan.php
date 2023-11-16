<?php

namespace Kanekescom\Simgtk\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BidangStudiPendidikan extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    public function getTable()
    {
        return config('simgtk.table_prefix').'bidang_studi_pendidikan';
    }

    public function pegawai(): HasMany
    {
        return $this->hasMany(Pegawai::class);
    }
}
