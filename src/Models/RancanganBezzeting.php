<?php

namespace Kanekescom\Simgtk\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kanekescom\Simgtk\Enums\StatusKepegawaianEnum;

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

        static::saving(function ($model) {
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

            foreach ($jenjang_mapels as $jenjang_sekolah => $mapels) {
                foreach ($mapels as $mapel) {
                    $field_jenjang_sekolah_mapel_abk = "{$jenjang_sekolah}_{$mapel}_abk";
                    $field_jenjang_sekolah_mapel_pns = "{$jenjang_sekolah}_{$mapel}_pns";
                    $field_jenjang_sekolah_mapel_pppk = "{$jenjang_sekolah}_{$mapel}_pppk";
                    $field_jenjang_sekolah_mapel_gtt = "{$jenjang_sekolah}_{$mapel}_gtt";
                    $field_jenjang_sekolah_mapel_total = "{$jenjang_sekolah}_{$mapel}_total";
                    $field_jenjang_sekolah_mapel_selisih = "{$jenjang_sekolah}_{$mapel}_selisih";

                    $field_jenjang_sekolah_mapel_abk_sum[] = $model->$field_jenjang_sekolah_mapel_abk = $model->$field_jenjang_sekolah_mapel_abk;
                    $field_jenjang_sekolah_mapel_abk_sum_status_kepegawaian_pns[] = $field_jenjang_sekolah_mapel_status_kepegawaian['pns'] = $model->$field_jenjang_sekolah_mapel_pns = $model->$field_jenjang_sekolah_mapel_pns;
                    $field_jenjang_sekolah_mapel_abk_sum_status_kepegawaian_pppk[] = $field_jenjang_sekolah_mapel_status_kepegawaian['pppk'] = $model->$field_jenjang_sekolah_mapel_pppk = $model->$field_jenjang_sekolah_mapel_pppk;
                    $field_jenjang_sekolah_mapel_abk_sum_status_kepegawaian_gtt[] = $field_jenjang_sekolah_mapel_status_kepegawaian['gtt'] = $model->$field_jenjang_sekolah_mapel_gtt = $model->$field_jenjang_sekolah_mapel_gtt;
                    $model->$field_jenjang_sekolah_mapel_total = array_sum($field_jenjang_sekolah_mapel_status_kepegawaian);
                    $model->$field_jenjang_sekolah_mapel_selisih = $model->$field_jenjang_sekolah_mapel_abk - $model->$field_jenjang_sekolah_mapel_total;

                    $field_jenjang_sekolah_mapel_existing_pns = "{$jenjang_sekolah}_{$mapel}_existing_pns";
                    $field_jenjang_sekolah_mapel_existing_pppk = "{$jenjang_sekolah}_{$mapel}_existing_pppk";
                    $field_jenjang_sekolah_mapel_existing_gtt = "{$jenjang_sekolah}_{$mapel}_existing_gtt";
                    $field_jenjang_sekolah_mapel_existing_total = "{$jenjang_sekolah}_{$mapel}_existing_total";
                    $field_jenjang_sekolah_mapel_existing_selisih = "{$jenjang_sekolah}_{$mapel}_existing_selisih";

                    $field_jenjang_sekolah_mapel_existing_abk_sum_status_kepegawaian_pns[] = $field_jenjang_sekolah_mapel_existing_status_kepegawaian['pns'] = $model->$field_jenjang_sekolah_mapel_existing_pns = $model->$field_jenjang_sekolah_mapel_existing_pns;
                    $field_jenjang_sekolah_mapel_existing_abk_sum_status_kepegawaian_pppk[] = $field_jenjang_sekolah_mapel_existing_status_kepegawaian['pppk'] = $model->$field_jenjang_sekolah_mapel_existing_pppk = $model->$field_jenjang_sekolah_mapel_existing_pppk;
                    $field_jenjang_sekolah_mapel_existing_abk_sum_status_kepegawaian_gtt[] = $field_jenjang_sekolah_mapel_existing_status_kepegawaian['gtt'] = $model->$field_jenjang_sekolah_mapel_existing_gtt = $model->$field_jenjang_sekolah_mapel_existing_gtt;
                    $model->$field_jenjang_sekolah_mapel_existing_total = array_sum($field_jenjang_sekolah_mapel_existing_status_kepegawaian);
                    $model->$field_jenjang_sekolah_mapel_existing_selisih = $model->$field_jenjang_sekolah_mapel_abk - $model->$field_jenjang_sekolah_mapel_total;
                }

                $field_jenjang_sekolah_formasi_abk = "{$jenjang_sekolah}_formasi_abk";
                $field_jenjang_sekolah_formasi_pns = "{$jenjang_sekolah}_formasi_pns";
                $field_jenjang_sekolah_formasi_pppk = "{$jenjang_sekolah}_formasi_pppk";
                $field_jenjang_sekolah_formasi_gtt = "{$jenjang_sekolah}_formasi_gtt";
                $field_jenjang_sekolah_formasi_total = "{$jenjang_sekolah}_formasi_total";
                $field_jenjang_sekolah_formasi_selisih = "{$jenjang_sekolah}_formasi_selisih";

                $model->$field_jenjang_sekolah_formasi_abk = array_sum($field_jenjang_sekolah_mapel_abk_sum);
                $field_jenjang_sekolah_formasi_status_kepegawaian['pns'] = $model->$field_jenjang_sekolah_formasi_pns = array_sum($field_jenjang_sekolah_mapel_abk_sum_status_kepegawaian_pns);
                $field_jenjang_sekolah_formasi_status_kepegawaian['pppk'] = $model->$field_jenjang_sekolah_formasi_pppk = array_sum($field_jenjang_sekolah_mapel_abk_sum_status_kepegawaian_pppk);
                $field_jenjang_sekolah_formasi_status_kepegawaian['gtt'] = $model->$field_jenjang_sekolah_formasi_gtt = array_sum($field_jenjang_sekolah_mapel_abk_sum_status_kepegawaian_gtt);
                $model->$field_jenjang_sekolah_formasi_total = array_sum($field_jenjang_sekolah_formasi_status_kepegawaian);
                $model->$field_jenjang_sekolah_formasi_selisih = $model->$field_jenjang_sekolah_formasi_abk - $model->$field_jenjang_sekolah_formasi_total;

                $field_jenjang_sekolah_formasi_existing_pns = "{$jenjang_sekolah}_formasi_existing_pns";
                $field_jenjang_sekolah_formasi_existing_pppk = "{$jenjang_sekolah}_formasi_existing_pppk";
                $field_jenjang_sekolah_formasi_existing_gtt = "{$jenjang_sekolah}_formasi_existing_gtt";
                $field_jenjang_sekolah_formasi_existing_total = "{$jenjang_sekolah}_formasi_existing_total";
                $field_jenjang_sekolah_formasi_existing_selisih = "{$jenjang_sekolah}_formasi_existing_selisih";

                $field_jenjang_sekolah_formasi_existing_status_kepegawaian['pns'] = $model->$field_jenjang_sekolah_formasi_existing_pns = array_sum($field_jenjang_sekolah_mapel_existing_abk_sum_status_kepegawaian_pns);
                $field_jenjang_sekolah_formasi_existing_status_kepegawaian['pppk'] = $model->$field_jenjang_sekolah_formasi_existing_pppk = array_sum($field_jenjang_sekolah_mapel_existing_abk_sum_status_kepegawaian_pppk);
                $field_jenjang_sekolah_formasi_existing_status_kepegawaian['gtt'] = $model->$field_jenjang_sekolah_formasi_existing_gtt = array_sum($field_jenjang_sekolah_mapel_existing_abk_sum_status_kepegawaian_gtt);
                $model->$field_jenjang_sekolah_formasi_existing_total = array_sum($field_jenjang_sekolah_formasi_existing_status_kepegawaian);
                $model->$field_jenjang_sekolah_formasi_existing_selisih = $model->$field_jenjang_sekolah_formasi_abk - $model->$field_jenjang_sekolah_formasi_existing_total;
            }
        });
    }

    public function getNamaWilayahAttribute()
    {
        return "{$this->nama}, {$this->wilayah?->nama}";
    }

    public function getSdKelasExistingTotalAttribute()
    {
        return $this->pegawaiSdKelas()->count();
    }
    public function getSdKelasExistingSelisihAttribute()
    {
        return $this->sd_kelas_abk - $this->sd_kelas_existing_total;
    }

    public function getSdPenjaskesExistingTotalAttribute()
    {
        return $this->pegawaiSdPenjaskes()->count();
    }
    public function getSdPenjaskesExistingSelisihAttribute()
    {
        return $this->sd_penjaskes_abk - $this->sd_penjaskes_existing_total;
    }

    public function getSdAgamaExistingTotalAttribute()
    {
        return $this->pegawaiSdAgama()->count();
    }
    public function getSdAgamaExistingSelisihAttribute()
    {
        return $this->sd_agama_abk - $this->sd_agama_existing_total;
    }

    public function getSdAgamaNoniExistingTotalAttribute()
    {
        return $this->pegawaiSdAgamaNoni()->count();
    }
    public function getSdAgamaNoniExistingSelisihAttribute()
    {
        return $this->sd_agama_noni_abk - $this->sd_agama_noni_existing_total;
    }

    public function getSdFormasiExistingTotalAttribute()
    {
        return $this->pegawaiSd()->count();
    }
    public function getSdFormasiExistingSelisihAttribute()
    {
        return $this->sd_formasi_abk - $this->sd_formasi_existing_total;
    }

    public function getSmpPaiExistingTotalAttribute()
    {
        return $this->pegawaiSmpPai()->count();
    }
    public function getSmpPaiExistingSelisihAttribute()
    {
        return $this->smp_pai_abk - $this->smp_pai_existing_total;
    }

    public function getSmpPjokExistingTotalAttribute()
    {
        return $this->pegawaiSmpPjok()->count();
    }
    public function getSmpPjokExistingSelisihAttribute()
    {
        return $this->smp_pjok_abk - $this->smp_pjok_existing_total;
    }

    public function getSmpBIndonesiaExistingTotalAttribute()
    {
        return $this->pegawaiSmpBIndonesia()->count();
    }
    public function getSmpBIndonesiaExistingSelisihAttribute()
    {
        return $this->smp_b_indonesia_abk - $this->smp_b_indonesia_existing_total;
    }

    public function getSmpBInggrisExistingTotalAttribute()
    {
        return $this->pegawaiSmpBInggris()->count();
    }
    public function getSmpBInggrisExistingSelisihAttribute()
    {
        return $this->smp_b_inggris_abk - $this->smp_b_inggris_existing_total;
    }

    public function getSmpBkExistingTotalAttribute()
    {
        return $this->pegawaiSmpBk()->count();
    }
    public function getSmpBkExistingSelisihAttribute()
    {
        return $this->smp_bk_abk - $this->smp_bk_existing_total;
    }

    public function getSmpIpaExistingTotalAttribute()
    {
        return $this->pegawaiSmpIpa()->count();
    }
    public function getSmpIpaExistingSelisihAttribute()
    {
        return $this->smp_ipa_abk - $this->smp_ipa_existing_total;
    }

    public function getSmpIpsExistingTotalAttribute()
    {
        return $this->pegawaiSmpIps()->count();
    }
    public function getSmpIpsExistingSelisihAttribute()
    {
        return $this->smp_ips_abk - $this->smp_ips_existing_total;
    }

    public function getSmpMatematikaExistingTotalAttribute()
    {
        return $this->pegawaiSmpMatematika()->count();
    }
    public function getSmpMatematikaExistingSelisihAttribute()
    {
        return $this->smp_matematika_abk - $this->smp_matematika_existing_total;
    }

    public function getSmpPpknExistingTotalAttribute()
    {
        return $this->pegawaiSmpPpkn()->count();
    }
    public function getSmpPpknExistingSelisihAttribute()
    {
        return $this->smp_ppkn_abk - $this->smp_ppkn_existing_total;
    }

    public function getSmpPrakaryaExistingTotalAttribute()
    {
        return $this->pegawaiSmpPrakarya()->count();
    }
    public function getSmpPrakaryaExistingSelisihAttribute()
    {
        return $this->smp_prakarya_abk - $this->smp_prakarya_existing_total;
    }

    public function getSmpSeniBudayaExistingTotalAttribute()
    {
        return $this->pegawaiSmpSeniBudaya()->count();
    }
    public function getSmpSeniBudayaExistingSelisihAttribute()
    {
        return $this->smp_seni_budaya_abk - $this->smp_seni_budaya_existing_total;
    }

    public function getSmpBSundaExistingTotalAttribute()
    {
        return $this->pegawaiSmpBSunda()->count();
    }
    public function getSmpBSundaExistingSelisihAttribute()
    {
        return $this->smp_b_sunda_abk - $this->smp_b_sunda_existing_total;
    }

    public function getSmpTikExistingTotalAttribute()
    {
        return $this->pegawaiSmpTik()->count();
    }
    public function getSmpTikExistingSelisihAttribute()
    {
        return $this->smp_tik_abk - $this->smp_tik_existing_total;
    }

    public function getSmpFormasiExistingTotalAttribute()
    {
        return $this->pegawaiSmp()->count();
    }
    public function getSmpFormasiExistingSelisihAttribute()
    {
        return $this->smp_formasi_abk - $this->smp_formasi_existing_total;
    }

    public function rencana(): BelongsTo
    {
        return $this->belongsTo(RencanaBezzeting::class, 'rencana_bezzeting_id');
    }

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function jenjangSekolah(): BelongsTo
    {
        return $this->belongsTo(JenjangSekolah::class);
    }

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function pegawai(): HasManyThrough
    {
        return $this->hasManyThrough(
            Pegawai::class,
            Sekolah::class,
            'id',
            'sekolah_id',
            'sekolah_id',
            'id',
        );
    }

    public function pegawaiKepsek(): HasManyThrough
    {
        return $this->pegawai()->where('is_kepsek', true);
    }
    public function pegawaiPltKepsek(): HasManyThrough
    {
        return $this->pegawai()->where('is_plt_kepsek', true);
    }

    public function pegawaiStatusKepegawaianPns(): HasManyThrough
    {
        return $this->pegawai()->where('status_kepegawaian_kode', StatusKepegawaianEnum::PNS);
    }
    public function pegawaiStatusKepegawaianPppk(): HasManyThrough
    {
        return $this->pegawai()->where('status_kepegawaian_kode', StatusKepegawaianEnum::PPPK);
    }
    public function pegawaiStatusKepegawaianGtt(): HasManyThrough
    {
        return $this->pegawai()->where('status_kepegawaian_kode', StatusKepegawaianEnum::NONASN);
    }

    public function pegawaiSd(): HasManyThrough
    {
        return $this->pegawai()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', [
                    'sd_kelas',
                    'sd_penjaskes',
                    'sd_agama',
                    'sd_agama_noni',
                ]);
            });
    }

    public function pegawaiSdKelas(): HasManyThrough
    {
        return $this->pegawai()
            ->whereHas('mataPelajaran', function ($query) {
                $query->where('kode', 'sd_kelas');
            });
    }
    public function pegawaiSdPenjaskes(): HasManyThrough
    {
        return $this->pegawai()
            ->whereHas('mataPelajaran', function ($query) {
                $query->where('kode', 'sd_penjaskes');
            });
    }
    public function pegawaiSdAgama(): HasManyThrough
    {
        return $this->pegawai()
            ->whereHas('mataPelajaran', function ($query) {
                $query->where('kode', 'sd_agama');
            });
    }
    public function pegawaiSdAgamaNoni(): HasManyThrough
    {
        return $this->pegawai()
            ->whereHas('mataPelajaran', function ($query) {
                $query->where('kode', 'sd_agama_noni');
            });
    }

    public function pegawaiSdStatusKepegawaianPns(): HasManyThrough
    {
        return $this->pegawaiSd()
            ->where('status_kepegawaian_kode', StatusKepegawaianEnum::PNS);
    }
    public function pegawaiSdStatusKepegawaianPppk(): HasManyThrough
    {
        return $this->pegawaiSd()
            ->where('status_kepegawaian_kode', StatusKepegawaianEnum::PPPK);
    }
    public function pegawaiSdStatusKepegawaianGtt(): HasManyThrough
    {
        return $this->pegawaiSd()
            ->where('status_kepegawaian_kode', StatusKepegawaianEnum::NONASN);
    }

    public function pegawaiSmp(): HasManyThrough
    {
        return $this->pegawai()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', [
                    'smp_pai',
                    'smp_pjok',
                    'smp_b_indonesia',
                    'smp_b_inggris',
                    'smp_bk',
                    'smp_ipa',
                    'smp_ips',
                    'smp_matematika',
                    'smp_ppkn',
                    'smp_prakarya',
                    'smp_seni_budaya',
                    'smp_b_sunda',
                    'smp_tik',
                ]);
            });
    }

    public function pegawaiSmpPai(): HasManyThrough
    {
        return $this->pegawai()
            ->whereHas('mataPelajaran', function ($query) {
                $query->where('kode', 'smp_pai');
            });
    }
    public function pegawaiSmpPjok(): HasManyThrough
    {
        return $this->pegawai()
            ->whereHas('mataPelajaran', function ($query) {
                $query->where('kode', 'smp_pjok');
            });
    }
    public function pegawaiSmpBIndonesia(): HasManyThrough
    {
        return $this->pegawai()
            ->whereHas('mataPelajaran', function ($query) {
                $query->where('kode', 'smp_b_indonesia');
            });
    }
    public function pegawaiSmpBInggris(): HasManyThrough
    {
        return $this->pegawai()
            ->whereHas('mataPelajaran', function ($query) {
                $query->where('kode', 'smp_b_inggris');
            });
    }
    public function pegawaiSmpBk(): HasManyThrough
    {
        return $this->pegawai()
            ->whereHas('mataPelajaran', function ($query) {
                $query->where('kode', 'smp_bk');
            });
    }
    public function pegawaiSmpIpa(): HasManyThrough
    {
        return $this->pegawai()
            ->whereHas('mataPelajaran', function ($query) {
                $query->where('kode', 'smp_ipa');
            });
    }
    public function pegawaiSmpIps(): HasManyThrough
    {
        return $this->pegawai()
            ->whereHas('mataPelajaran', function ($query) {
                $query->where('kode', 'smp_ips');
            });
    }
    public function pegawaiSmpMatematika(): HasManyThrough
    {
        return $this->pegawai()
            ->whereHas('mataPelajaran', function ($query) {
                $query->where('kode', 'smp_matematika');
            });
    }
    public function pegawaiSmpPpkn(): HasManyThrough
    {
        return $this->pegawai()
            ->whereHas('mataPelajaran', function ($query) {
                $query->where('kode', 'smp_ppkn');
            });
    }
    public function pegawaiSmpPrakarya(): HasManyThrough
    {
        return $this->pegawai()
            ->whereHas('mataPelajaran', function ($query) {
                $query->where('kode', 'smp_prakarya');
            });
    }
    public function pegawaiSmpSeniBudaya(): HasManyThrough
    {
        return $this->pegawai()
            ->whereHas('mataPelajaran', function ($query) {
                $query->where('kode', 'smp_seni_budaya');
            });
    }
    public function pegawaiSmpBSunda(): HasManyThrough
    {
        return $this->pegawai()
            ->whereHas('mataPelajaran', function ($query) {
                $query->where('kode', 'smp_b_sunda');
            });
    }
    public function pegawaiSmpTik(): HasManyThrough
    {
        return $this->pegawai()
            ->whereHas('mataPelajaran', function ($query) {
                $query->where('kode', 'smp_tik');
            });
    }

    public function pegawaiSmpStatusKepegawaianPns(): HasManyThrough
    {
        return $this->pegawaiSmp()
            ->where('status_kepegawaian_kode', StatusKepegawaianEnum::PNS);
    }
    public function pegawaiSmpStatusKepegawaianPppk(): HasManyThrough
    {
        return $this->pegawaiSmp()
            ->where('status_kepegawaian_kode', StatusKepegawaianEnum::PPPK);
    }
    public function pegawaiSmpStatusKepegawaianGtt(): HasManyThrough
    {
        return $this->pegawaiSmp()
            ->where('status_kepegawaian_kode', StatusKepegawaianEnum::NONASN);
    }

    public function scopeAktif($query)
    {
        return $query
            ->whereHas('rencana', function ($query) {
                $query->where('is_aktif', true);
            });
    }

    public function scopeDefaultOrder($query)
    {
        return $query
            ->with(['wilayah' => function ($query) {
                $query->orderBy('nama', 'asc');
            }]);
    }
}
