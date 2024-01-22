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

class Sekolah extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $guarded = [];

    public function getTable()
    {
        return config('simgtk.table_prefix').'sekolah';
    }

    public function getNamaWilayahAttribute()
    {
        return "{$this->nama}, {$this->wilayah?->nama}";
    }

    public function getSdKelasJumlahAttribute()
    {
        return $this->sd_kelas_pns + $this->sd_kelas_pppk + $this->sd_kelas_gtt;
    }

    public function getSdKelasJumlahExistingAttribute()
    {
        return $this->mataPelajaranSdKelas()->count();
    }

    public function getSdKelasSelisihAttribute()
    {
        return $this->sd_kelas_abk - $this->sd_kelas_jumlah;
    }

    public function getSdKelasSelisihExistingAttribute()
    {
        return $this->sd_kelas_jumlah_existing - $this->sd_kelas_jumlah;
    }

    public function getSdPenjaskesJumlahAttribute()
    {
        return $this->sd_penjaskes_pns + $this->sd_penjaskes_pppk + $this->sd_penjaskes_gtt;
    }

    public function getSdPenjaskesJumlahExistingAttribute()
    {
        return $this->mataPelajaranSdPenjaskes()->count();
    }

    public function getSdPenjaskesSelisihAttribute()
    {
        return $this->sd_penjaskes_abk - $this->sd_penjaskes_jumlah;
    }

    public function getSdPenjaskesSelisihExistingAttribute()
    {
        return $this->sd_penjaskes_jumlah_existing - $this->sd_penjaskes_jumlah;
    }

    public function getSdAgamaJumlahAttribute()
    {
        return $this->sd_agama_pns + $this->sd_agama_pppk + $this->sd_agama_gtt;
    }

    public function getSdAgamaJumlahExistingAttribute()
    {
        return $this->mataPelajaranSdAgama()->count();
    }

    public function getSdAgamaSelisihAttribute()
    {
        return $this->sd_agama_abk - $this->sd_agama_jumlah;
    }

    public function getSdAgamaSelisihExistingAttribute()
    {
        return $this->sd_agama_jumlah_existing - $this->sd_agama_jumlah;
    }

    public function getSdAgamaNoniJumlahAttribute()
    {
        return $this->sd_agama_noni_pns + $this->sd_agama_noni_pppk + $this->sd_agama_noni_gtt;
    }

    public function getSdAgamaNoniJumlahExistingAttribute()
    {
        return $this->mataPelajaranSdAgamaNoni()->count();
    }

    public function getSdAgamaNoniSelisihAttribute()
    {
        return $this->sd_agama_noni_abk - $this->sd_agama_noni_jumlah;
    }

    public function getSdAgamaNoniSelisihExistingAttribute()
    {
        return $this->sd_agama_noni_jumlah_existing - $this->sd_agama_noni_jumlah;
    }

    //

    public function getSmpPaiJumlahAttribute()
    {
        return $this->smp_pai_pns + $this->smp_pai_pppk + $this->smp_pai_gtt;
    }

    public function getSmpPaiJumlahExistingAttribute()
    {
        return $this->mataPelajaranSmpPai()->count();
    }

    public function getSmpPaiSelisihAttribute()
    {
        return $this->smp_pai_abk - $this->smp_pai_jumlah;
    }

    public function getSmpPaiSelisihExistingAttribute()
    {
        return $this->smp_pai_jumlah_existing - $this->smp_pai_jumlah;
    }

    public function getSmpPjokJumlahAttribute()
    {
        return $this->smp_pjok_pns + $this->smp_pjok_pppk + $this->smp_pjok_gtt;
    }

    public function getSmpPjokJumlahExistingAttribute()
    {
        return $this->mataPelajaranSmpPjok()->count();
    }

    public function getSmpPjokSelisihAttribute()
    {
        return $this->smp_pjok_abk - $this->smp_pjok_jumlah;
    }

    public function getSmpPjokSelisihExistingAttribute()
    {
        return $this->smp_pjok_jumlah_existing - $this->smp_pjok_jumlah;
    }

    public function getSmpBIndonesiaJumlahAttribute()
    {
        return $this->smp_b_indonesia_pns + $this->smp_b_indonesia_pppk + $this->smp_b_indonesia_gtt;
    }

    public function getSmpBIndonesiaJumlahExistingAttribute()
    {
        return $this->mataPelajaranSmpBIndonesia()->count();
    }

    public function getSmpBIndonesiaSelisihAttribute()
    {
        return $this->smp_b_indonesia_abk - $this->smp_b_indonesia_jumlah;
    }

    public function getSmpBIndonesiaSelisihExistingAttribute()
    {
        return $this->smp_b_indonesia_jumlah_existing - $this->smp_b_indonesia_jumlah;
    }

    public function getSmpBInggrisJumlahAttribute()
    {
        return $this->smp_b_inggris_pns + $this->smp_b_inggris_pppk + $this->smp_b_inggris_gtt;
    }

    public function getSmpBInggrisJumlahExistingAttribute()
    {
        return $this->mataPelajaranSmpBInggris()->count();
    }

    public function getSmpBInggrisSelisihAttribute()
    {
        return $this->smp_b_inggris_abk - $this->smp_b_inggris_jumlah;
    }

    public function getSmpBInggrisSelisihExistingAttribute()
    {
        return $this->smp_b_inggris_jumlah_existing - $this->smp_b_inggris_jumlah;
    }

    public function getSmpBkJumlahAttribute()
    {
        return $this->smp_bk_pns + $this->smp_bk_pppk + $this->smp_bk_gtt;
    }

    public function getSmpBkJumlahExistingAttribute()
    {
        return $this->mataPelajaranSmpBk()->count();
    }

    public function getSmpBkSelisihAttribute()
    {
        return $this->smp_bk_abk - $this->smp_bk_jumlah;
    }

    public function getSmpBkSelisihExistingAttribute()
    {
        return $this->smp_bk_jumlah_existing - $this->smp_bk_jumlah;
    }

    public function getSmpIpaJumlahAttribute()
    {
        return $this->smp_ipa_pns + $this->smp_ipa_pppk + $this->smp_ipa_gtt;
    }

    public function getSmpIpaJumlahExistingAttribute()
    {
        return $this->mataPelajaranSmpIpa()->count();
    }

    public function getSmpIpaSelisihAttribute()
    {
        return $this->smp_ipa_abk - $this->smp_ipa_jumlah;
    }

    public function getSmpIpaSelisihExistingAttribute()
    {
        return $this->smp_ipa_jumlah_existing - $this->smp_ipa_jumlah;
    }

    public function getSmpIpsJumlahAttribute()
    {
        return $this->smp_ips_pns + $this->smp_ips_pppk + $this->smp_ips_gtt;
    }

    public function getSmpIpsJumlahExistingAttribute()
    {
        return $this->mataPelajaranSmpIps()->count();
    }

    public function getSmpIpsSelisihAttribute()
    {
        return $this->smp_ips_abk - $this->smp_ips_jumlah;
    }

    public function getSmpIpsSelisihExistingAttribute()
    {
        return $this->smp_ips_jumlah_existing - $this->smp_ips_jumlah;
    }

    public function getSmpMatematikaJumlahAttribute()
    {
        return $this->smp_matematika_pns + $this->smp_matematika_pppk + $this->smp_matematika_gtt;
    }

    public function getSmpMatematikaJumlahExistingAttribute()
    {
        return $this->mataPelajaranSmpMatematika()->count();
    }

    public function getSmpMatematikaSelisihAttribute()
    {
        return $this->smp_matematika_abk - $this->smp_matematika_jumlah;
    }

    public function getSmpMatematikaSelisihExistingAttribute()
    {
        return $this->smp_matematika_jumlah_existing - $this->smp_matematika_jumlah;
    }

    public function getSmpPpknJumlahAttribute()
    {
        return $this->smp_ppkn_pns + $this->smp_ppkn_pppk + $this->smp_ppkn_gtt;
    }

    public function getSmpPpknJumlahExistingAttribute()
    {
        return $this->mataPelajaranSmpPpkn()->count();
    }

    public function getSmpPpknSelisihAttribute()
    {
        return $this->smp_ppkn_abk - $this->smp_ppkn_jumlah;
    }

    public function getSmpPpknSelisihExistingAttribute()
    {
        return $this->smp_ppkn_jumlah_existing - $this->smp_ppkn_jumlah;
    }

    public function getSmpPrakaryaJumlahAttribute()
    {
        return $this->smp_prakarya_pns + $this->smp_prakarya_pppk + $this->smp_prakarya_gtt;
    }

    public function getSmpPrakaryaJumlahExistingAttribute()
    {
        return $this->mataPelajaranSmpPrakarya()->count() ;
    }

    public function getSmpPrakaryaSelisihAttribute()
    {
        return $this->smp_prakarya_abk - $this->smp_prakarya_jumlah;
    }

    public function getSmpPrakaryaSelisihExistingAttribute()
    {
        return $this->smp_prakarya_jumlah_existing - $this->smp_prakarya_jumlah;
    }

    public function getSmpSeniBudayaJumlahAttribute()
    {
        return $this->smp_seni_budaya_pns + $this->smp_seni_budaya_pppk + $this->smp_seni_budaya_gtt;
    }

    public function getSmpSeniBudayaJumlahExistingAttribute()
    {
        return $this->mataPelajaranSmpSeniBudaya()->count();
    }

    public function getSmpSeniBudayaSelisihAttribute()
    {
        return $this->smp_seni_budaya_abk - $this->smp_seni_budaya_jumlah;
    }

    public function getSmpSeniBudayaSelisihExistingAttribute()
    {
        return $this->smp_seni_budaya_jumlah_existing - $this->smp_seni_budaya_jumlah;
    }

    public function getSmpBSundaJumlahAttribute()
    {
        return $this->smp_b_sunda_pns + $this->smp_b_sunda_pppk + $this->smp_b_sunda_gtt;
    }

    public function getSmpBSundaJumlahExistingAttribute()
    {
        return $this->mataPelajaranSmpBSunda()->count();
    }

    public function getSmpBSundaSelisihAttribute()
    {
        return $this->smp_b_sunda_abk - $this->smp_b_sunda_jumlah;
    }

    public function getSmpBSundaSelisihExistingAttribute()
    {
        return $this->smp_b_sunda_jumlah_existing - $this->smp_b_sunda_jumlah;
    }

    public function getSmpTikJumlahAttribute()
    {
        return $this->smp_tik_pns + $this->smp_tik_pppk + $this->smp_tik_gtt;
    }

    public function getSmpTikJumlahExistingAttribute()
    {
        return $this->mataPelajaranSmpTik()->count();
    }

    public function getSmpTikSelisihAttribute()
    {
        return $this->smp_tik_abk - $this->smp_tik_jumlah;
    }

    public function getSmpTikSelisihExistingAttribute()
    {
        return $this->smp_tik_jumlah_existing - $this->smp_tik_jumlah;
    }

    //

    public function getSdJumlahAbkAttribute()
    {
        return
            $this->sd_kelas_abk
            + $this->sd_penjaskes_abk
            + $this->sd_agama_abk
            + $this->sd_agama_noni_abk;
    }

    public function getSdJumlahFormasiAttribute()
    {
        return
            $this->sd_kelas_jumlah
            + $this->sd_penjaskes_jumlah
            + $this->sd_agama_jumlah
            + $this->sd_agama_noni_jumlah;
    }

    public function getSdJumlahExistingAttribute()
    {
        return
            $this->sd_kelas_jumlah_existing
            + $this->sd_penjaskes_jumlah_existing
            + $this->sd_agama_jumlah_existing
            + $this->sd_agama_noni_jumlah_existing;
    }

    public function getSdJumlahSelisihAttribute()
    {
        return
            $this->sd_jumlah_abk
            - $this->sd_jumlah_formasi;
    }

    public function getSdJumlahSelisihExistingAttribute()
    {
        return $this->sd_jumlah_existing - $this->sd_jumlah_formasi;
    }

    //

    public function getSmpJumlahAbkAttribute()
    {
        return
            $this->smp_pai_abk
            + $this->smp_pjok_abk
            + $this->smp_b_indonesia_abk
            + $this->smp_b_inggris_abk
            + $this->smp_bk_abk
            + $this->smp_ipa_abk
            + $this->smp_ips_abk
            + $this->smp_matematika_abk
            + $this->smp_ppkn_abk
            + $this->smp_prakarya_abk
            + $this->smp_seni_budaya_abk
            + $this->smp_b_sunda_abk
            + $this->smp_tik_abk;
    }

    public function getSmpJumlahFormasiAttribute()
    {
        return
            $this->smp_pai_jumlah
            + $this->smp_pjok_jumlah
            + $this->smp_b_indonesia_jumlah
            + $this->smp_b_inggris_jumlah
            + $this->smp_bk_jumlah
            + $this->smp_ipa_jumlah
            + $this->smp_ips_jumlah
            + $this->smp_matematika_jumlah
            + $this->smp_ppkn_jumlah
            + $this->smp_prakarya_jumlah
            + $this->smp_seni_budaya_jumlah
            + $this->smp_b_sunda_jumlah
            + $this->smp_tik_jumlah;
    }

    public function getSmpJumlahExistingAttribute()
    {
        return
            $this->smp_pai_jumlah_existing
            + $this->smp_pjok_jumlah_existing
            + $this->smp_b_indonesia_jumlah_existing
            + $this->smp_b_inggris_jumlah_existing
            + $this->smp_bk_jumlah_existing
            + $this->smp_ipa_jumlah_existing
            + $this->smp_ips_jumlah_existing
            + $this->smp_matematika_jumlah_existing
            + $this->smp_ppkn_jumlah_existing
            + $this->smp_prakarya_jumlah_existing
            + $this->smp_seni_budaya_jumlah_existing
            + $this->smp_b_sunda_jumlah_existing
            + $this->smp_tik_jumlah_existing;
    }

    public function getSmpJumlahSelisihAttribute()
    {
        return
            $this->smp_jumlah_abk
            - $this->smp_jumlah_formasi;
    }

    public function getSmpJumlahSelisihExistingAttribute()
    {
        return $this->smp_jumlah_existing - $this->smp_jumlah_formasi;
    }

    //

    public function jenjangSekolah(): BelongsTo
    {
        return $this->belongsTo(JenjangSekolah::class);
    }

    public function pegawai(): HasMany
    {
        return $this->hasMany(Pegawai::class);
    }

    public function pegawaiStatusKepegawaianPns(): HasMany
    {
        return $this->pegawai()->where('status_kepegawaian_kode', StatusKepegawaianEnum::PNS);
    }

    public function pegawaiStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawai()->where('status_kepegawaian_kode', StatusKepegawaianEnum::PPPK);
    }

    public function pegawaiStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawai()->where('status_kepegawaian_kode', StatusKepegawaianEnum::NONASN);
    }

    public function mataPelajaran(): HasManyThrough
    {
        return $this->hasManyThrough(
            MataPelajaran::class,
            Pegawai::class,
            'sekolah_id',
            'id',
            'id',
            'mata_pelajaran_id',
        );
    }

    public function mataPelajaranSdKelas(): HasManyThrough
    {
        return $this->mataPelajaran()->where('kode', 'sd_kelas');
    }

    public function mataPelajaranSdPenjaskes(): HasManyThrough
    {
        return $this->mataPelajaran()->where('kode', 'sd_penjaskes');
    }

    public function mataPelajaranSdAgama(): HasManyThrough
    {
        return $this->mataPelajaran()->where('kode', 'sd_agama');
    }

    public function mataPelajaranSdAgamaNoni(): HasManyThrough
    {
        return $this->mataPelajaran()->where('kode', 'sd_agama_noni');
    }

    public function mataPelajaranSmpPai(): HasManyThrough
    {
        return $this->mataPelajaran()->where('kode', 'smp_pai');
    }

    public function mataPelajaranSmpPjok(): HasManyThrough
    {
        return $this->mataPelajaran()->where('kode', 'smp_pjok');
    }

    public function mataPelajaranSmpBIndonesia(): HasManyThrough
    {
        return $this->mataPelajaran()->where('kode', 'smp_b_indonesia');
    }

    public function mataPelajaranSmpBInggris(): HasManyThrough
    {
        return $this->mataPelajaran()->where('kode', 'smp_b_inggris');
    }

    public function mataPelajaranSmpBk(): HasManyThrough
    {
        return $this->mataPelajaran()->where('kode', 'smp_bk');
    }

    public function mataPelajaranSmpIpa(): HasManyThrough
    {
        return $this->mataPelajaran()->where('kode', 'smp_ipa');
    }

    public function mataPelajaranSmpIps(): HasManyThrough
    {
        return $this->mataPelajaran()->where('kode', 'smp_ips');
    }

    public function mataPelajaranSmpMatematika(): HasManyThrough
    {
        return $this->mataPelajaran()->where('kode', 'smp_matematika');
    }

    public function mataPelajaranSmpPpkn(): HasManyThrough
    {
        return $this->mataPelajaran()->where('kode', 'smp_ppkn');
    }

    public function mataPelajaranSmpPrakarya(): HasManyThrough
    {
        return $this->mataPelajaran()->where('kode', 'smp_prakarya');
    }

    public function mataPelajaranSmpSeniBudaya(): HasManyThrough
    {
        return $this->mataPelajaran()->where('kode', 'smp_seni_budaya');
    }

    public function mataPelajaranSmpBSunda(): HasManyThrough
    {
        return $this->mataPelajaran()->where('kode', 'smp_b_sunda');
    }

    public function mataPelajaranSmpTik(): HasManyThrough
    {
        return $this->mataPelajaran()->where('kode', 'smp_tik');
    }

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function scopeCountByJenjangSekolah($query)
    {
        return $query
            ->select('jenjang_sekolah_id', \DB::raw('COUNT(*) as count'))
            ->with('jenjangSekolah')
            ->groupBy('jenjang_sekolah_id');
    }

    public function scopeCountByWilayah($query)
    {
        return $query
            ->select('wilayah_id', \DB::raw('COUNT(*) as count'))
            ->with('wilayah')
            ->groupBy('wilayah_id');
    }

    public function scopeDefaultOrder($query)
    {
        return $query
            ->with(['wilayah' => function ($query) {
                $query->orderBy('nama', 'asc');
            }]);
    }
}
