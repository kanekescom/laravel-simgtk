<?php

namespace Kanekescom\Simgtk\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BidangStudiSertifikasi extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    public function getTable()
    {
        return config('simgtk.table_prefix').'bidang_studi_sertifikasi';
    }

    public function pegawai(): HasMany
    {
        return $this->hasMany(Pegawai::class);
    }
}
