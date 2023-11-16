<?php

namespace Kanekescom\Simgtk\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kanekescom\Simgtk\Enums\GenderEnum;
use Kanekescom\Simgtk\Enums\GolonganAsnEnum;
use Kanekescom\Simgtk\Enums\JenjangPendidikanEnum;
use Kanekescom\Simgtk\Enums\StatusKepegawaianEnum;
use Kanekescom\Simgtk\Enums\StatusTugasEnum;

class Pegawai extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $casts = [
        'gender_kode' => GenderEnum::class,
        'jenjang_pendidikan_kode' => JenjangPendidikanEnum::class,
        'status_kepegawaian_kode' => StatusKepegawaianEnum::class,
        'golongan_kode' => GolonganAsnEnum::class,
        'status_tugas_kode' => StatusTugasEnum::class,
    ];

    public function getTable()
    {
        return config('simgtk.table_prefix') . 'pegawai';
    }

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function jenisPtk(): BelongsTo
    {
        return $this->belongsTo(JenisPtk::class);
    }

    public function bidangStudiPendidikan(): BelongsTo
    {
        return $this->belongsTo(BidangStudiPendidikan::class);
    }

    public function bidangStudiSertifikasi(): BelongsTo
    {
        return $this->belongsTo(BidangStudiSertifikasi::class);
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }
}
