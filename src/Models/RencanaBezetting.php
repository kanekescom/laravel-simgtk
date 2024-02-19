<?php

namespace Kanekescom\Simgtk\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class RencanaBezetting extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $guarded = [];

    public function getTable()
    {
        return config('simgtk.table_prefix').'rencana_bezetting';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $is_aktif = self::where('is_aktif', true);

            if ($is_aktif->count() > 0 && $model->is_aktif == true) {
                $is_aktif->update(['is_aktif' => false]);
            }

            $jenjang_mapels = [
                'sd' => [
                    'kelas',
                    'penjaskes',
                    'agama',
                    'agama_noni',
                ],
                'smp' => [
                    'pai',
                    'pjok',
                    'b_indonesia',
                    'b_inggris',
                    'bk',
                    'ipa',
                    'ips',
                    'matematika',
                    'ppkn',
                    'prakarya',
                    'seni_budaya',
                    'b_sunda',
                    'tik',
                ],
            ];

            $with_count_relationships[] = 'pegawaiKepsek as kepsek';
            $with_count_relationships[] = 'pegawaiPltKepsek as plt_kepsek';
            $with_count_relationships[] = 'pegawaiJabatanKepsek as jabatan_kepsek';

            foreach ($jenjang_mapels as $jenjang_sekolah => $mapels) {
                $jenjang_sekolah_studly = str($jenjang_sekolah)->studly();

                foreach ($mapels as $mapel) {
                    $mapel_studly = str($mapel)->studly();

                    $with_count_relationships[] = "pegawai{$jenjang_sekolah_studly}{$mapel_studly}StatusKepegawaianPns as {$jenjang_sekolah}_{$mapel}_existing_pns";
                    $with_count_relationships[] = "pegawai{$jenjang_sekolah_studly}{$mapel_studly}StatusKepegawaianPppk as {$jenjang_sekolah}_{$mapel}_existing_pppk";
                    $with_count_relationships[] = "pegawai{$jenjang_sekolah_studly}{$mapel_studly}StatusKepegawaianGtt as {$jenjang_sekolah}_{$mapel}_existing_gtt";
                    $with_count_relationships[] = "pegawai{$jenjang_sekolah_studly}{$mapel_studly} as {$jenjang_sekolah}_{$mapel}_existing_total";
                }

                $with_count_relationships[] = "pegawai{$jenjang_sekolah_studly}StatusKepegawaianPns as {$jenjang_sekolah}_formasi_existing_pns";
                $with_count_relationships[] = "pegawai{$jenjang_sekolah_studly}StatusKepegawaianPppk as {$jenjang_sekolah}_formasi_existing_pppk";
                $with_count_relationships[] = "pegawai{$jenjang_sekolah_studly}StatusKepegawaianGtt as {$jenjang_sekolah}_formasi_existing_gtt";
                $with_count_relationships[] = "pegawai{$jenjang_sekolah_studly} as {$jenjang_sekolah}_formasi_existing_total";
            }

            $sekolah = Sekolah::query()
                ->withCount($with_count_relationships ?? [])
                ->get()
                ->transform(function ($sekolah) {
                    $sekolah['sekolah_id'] = $sekolah['id'];
                    unset($sekolah['id']);

                    return $sekolah;
                })
                ->toArray();

            $model->bezetting()
                ->createMany($sekolah);

            $pegawai = Pegawai::query()
                ->aktif()
                ->get()
                ->transform(function ($pegawai) {
                    $pegawai['pegawai_id'] = $pegawai['id'];
                    unset($pegawai['id']);

                    return $pegawai;
                })
                ->toArray();

            $model->pegawai()
                ->createMany($pegawai);
        });

        static::updating(function ($model) {
            $is_aktif = self::where('is_aktif', true)->whereNot('id', $model->id);

            if ($is_aktif->count() > 0 && $model->is_aktif == true) {
                $is_aktif->update(['is_aktif' => false]);
            }
        });
    }

    public function getNamaPeriodeAttribute()
    {
        return "{$this->nama} ({$this->periode_tanggal})";
    }

    public function getPeriodeTanggalAttribute()
    {
        return "{$this->tanggal_mulai} - {$this->tanggal_berakhir}";
    }

    public function bezetting(): HasMany
    {
        return $this->hasMany(RancanganBezetting::class);
    }

    public function pegawai(): HasMany
    {
        return $this->hasMany(RancanganBezettingPegawai::class);
    }

    public function pegawaiAktif(): HasMany
    {
        return $this->pegawai()->aktif();
    }

    public function guru(): HasMany
    {
        return $this->pegawai()->guru();
    }

    public function guruAktif(): HasMany
    {
        return $this->pegawaiAktif()->guru();
    }

    public function sekolah(): HasManyThrough
    {
        return $this->hasManyThrough(
            Sekolah::class,
            RancanganBezetting::class,
            'rencana_bezetting_id',
            'id',
            'id',
            'sekolah_id',
        );
    }

    public function scopeAktif($query)
    {
        return $query
            ->where('is_aktif', true);
    }

    public function scopePeriodeAktif($query)
    {
        $today = now();

        return $query
            ->where('tanggal_mulai', '<=', $today)
            ->where('tanggal_berakhir', '>=', $today)
            ->where('is_aktif', true);
    }
}
