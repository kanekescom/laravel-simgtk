<?php

namespace Kanekescom\Simgtk\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
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

    protected $guarded = [];

    protected $casts = [
        'gender_kode' => GenderEnum::class,
        'jenjang_pendidikan_kode' => JenjangPendidikanEnum::class,
        'status_kepegawaian_kode' => StatusKepegawaianEnum::class,
        'golongan_kode' => GolonganAsnEnum::class,
        'status_tugas_kode' => StatusTugasEnum::class,
        'is_kepsek' => 'boolean',
    ];

    public function getTable()
    {
        return config('simgtk.table_prefix') . 'pegawai';
    }

    public function getNamaGelarAttribute()
    {
        return ($this->gelar_depan ? "{$this->gelar_depan} " : '')
            . $this->nama
            . ($this->gelar_belakang ? ", {$this->gelar_belakang}" : '');
    }

    public function getNamaIdAttribute()
    {
        if ($this->nip) {
            return "NIP. {$this->nik}";
        }

        if ($this->nuptk) {
            return "NUPTK. {$this->nuptk}";
        }

        return "NIK. {$this->nik}";
    }

    public function getNamaIdGelarAttribute()
    {
        return "{$this->nama_id} {$this->nama_gelar}";
    }

    public function getJadwalTmtPensiunAttribute()
    {
        return $this->tmt_pensiun ?? now()->parse($this->tanggal_lahir)->addYears(60)->toDateString();
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

    public function wilayahSekolah(): HasOneThrough
    {
        return $this->hasOneThrough(Wilayah::class, Sekolah::class);
    }

    public function scopeAktif($query)
    {
        return $query
            ->whereNull('tanggal_sk_pensiun')
            ->whereNull('nomor_sk_pensiun');
    }

    public function scopePensiun($query)
    {
        return $query
            ->whereNotNull('tanggal_sk_pensiun')
            ->orWhereNotNull('nomor_sk_pensiun');
    }

    public function scopeAkanPensiun($query)
    {
        $tanggal_pensiun = now()->subYears(60)->subYears(1)->toDateString();

        return $query
            ->aktif()
            ->whereDate('tanggal_lahir', '<=', $tanggal_pensiun);
    }

    public function scopeCountByGender($query)
    {
        return $query
            ->select('gender_kode', \DB::raw('COUNT(*) as count'))
            ->groupBy('gender_kode');
    }

    public function scopeCountByStatusKepegawaian($query)
    {
        return $query
            ->select('status_kepegawaian_kode', \DB::raw('COUNT(*) as count'))
            ->groupBy('status_kepegawaian_kode');
    }

    public function scopeCountByWilayahSekolah($query)
    {
        return $query
            ->select('se', \DB::raw('COUNT(*) as count'))
            ->groupBy('wilayahSekolah');
    }
}
