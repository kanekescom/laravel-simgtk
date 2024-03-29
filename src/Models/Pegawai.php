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
        'status_kepegawaian_kode' => StatusKepegawaianEnum::class,
        'golongan_kode' => GolonganAsnEnum::class,
        'status_tugas_kode' => StatusTugasEnum::class,
        'is_kepsek' => 'boolean',
        'is_plt_kepsek' => 'boolean',
    ];

    public function getTable()
    {
        return config('simgtk.table_prefix').'pegawai';
    }

    public function getNamaGelarAttribute()
    {
        return ($this->gelar_depan ? "{$this->gelar_depan} " : '')
            .$this->nama
            .($this->gelar_belakang ? ", {$this->gelar_belakang}" : '');
    }

    public function getNamaIdAttribute()
    {
        if ($this->nip) {
            return "NIP. {$this->nip}";
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

    public function jenjangPendidikan(): BelongsTo
    {
        return $this->belongsTo(JenjangPendidikan::class);
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

    public function wilayah(): HasOneThrough
    {
        return $this->hasOneThrough(
            Wilayah::class,
            Sekolah::class,
            'id',
            'id',
            'sekolah_id',
            'wilayah_id',
        );
    }

    public function scopeStatusKepegawaianAsn($query)
    {
        return $query
            ->whereIn('status_kepegawaian_kode', [StatusKepegawaianEnum::PNS, StatusKepegawaianEnum::PPPK]);
    }

    public function scopeStatusKepegawaianPns($query)
    {
        return $query
            ->where('status_kepegawaian_kode', StatusKepegawaianEnum::PNS);
    }

    public function scopeStatusKepegawaianPppk($query)
    {
        return $query
            ->where('status_kepegawaian_kode', StatusKepegawaianEnum::PPPK);
    }

    public function scopeStatusKepegawaianNonAsn($query)
    {
        return $query
            ->where('status_kepegawaian_kode', StatusKepegawaianEnum::NONASN);
    }

    public function scopeStatusKepegawaian($query, $status_kepegawaian_kode)
    {
        return $query
            ->where('status_kepegawaian_kode', $status_kepegawaian_kode);
    }

    public function scopeGenderLakiLaki($query)
    {
        return $query
            ->where('gender_kode', GenderEnum::LAKILAKI);
    }

    public function scopeGenderPerempuan($query)
    {
        return $query
            ->where('gender_kode', GenderEnum::PEREMPUAN);
    }

    public function scopeAktif($query)
    {
        return $query
            ->whereNull('tanggal_sk_pensiun')
            ->whereNull('nomor_sk_pensiun')
            ->whereDate('tmt_pensiun', '>=', now()->addMonth());
    }

    public function scopeGuru($query)
    {
        return $query
            ->whereNotNull('mata_pelajaran_id');
    }

    public function scopeGuruAktif($query)
    {
        return $query
            ->aktif()
            ->guru();
    }

    public function scopePensiun($query)
    {
        return $query
            ->whereNotNull('tanggal_sk_pensiun')
            ->orWhereNotNull('nomor_sk_pensiun');
    }

    public function scopeMasukPensiun($query)
    {
        return $query
            ->whereNull('tanggal_sk_pensiun')
            ->whereNull('nomor_sk_pensiun')
            ->whereDate('tmt_pensiun', '<', now())
            ->orderBy('tmt_pensiun');
    }

    public function scopePensiunTahun($query, $tahun)
    {
        return $query
            ->aktif()
            ->whereYear('tmt_pensiun', '=', $tahun)
            ->orderBy('tmt_pensiun');
    }

    public function scopePensiunTahunIni($query)
    {
        return $query
            ->aktif()
            ->whereYear('tmt_pensiun', '=', now()->year)
            ->orderBy('tmt_pensiun');
    }

    public function scopePensiunTahunDepan($query)
    {
        return $query
            ->aktif()
            ->whereYear('tmt_pensiun', '=', now()->addYear()->year)
            ->orderBy('tmt_pensiun');
    }

    public function scopeJenjangSekolahId($query, $jenjang_sekolah_id = null)
    {
        return $query
            ->whereHas('sekolah', function ($query) use ($jenjang_sekolah_id) {
                if (filled($jenjang_sekolah_id)) {
                    $query->where('jenjang_sekolah_id', $jenjang_sekolah_id);
                }
            });
    }
}
