<?php

namespace Kanekescom\Simgtk\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    //

    public function getSdKelasJumlahAttribute()
    {
        return $this->sd_kelas_pns+$this->sd_kelas_pppk+$this->sd_kelas_gtt;
    }

    public function getSdKelasSelisihAttribute()
    {
        return $this->sd_kelas_abk+$this->sd_kelas_jumlah;
    }

    public function getSdPenjaskesJumlahAttribute()
    {
        return $this->sd_penjaskes_pns+$this->sd_penjaskes_pppk+$this->sd_penjaskes_gtt;
    }

    public function getSdPenjaskesSelisihAttribute()
    {
        return $this->sd_penjaskes_abk+$this->sd_penjaskes_jumlah;
    }

    public function getSdAgamaJumlahAttribute()
    {
        return $this->sd_agama_pns+$this->sd_agama_pppk+$this->sd_agama_gtt;
    }

    public function getSdAgamaSelisihAttribute()
    {
        return $this->sd_agama_abk+$this->sd_agama_jumlah;
    }

    //

    public function getSmpPaiJumlahAttribute()
    {
        return $this->smp_pai_pns+$this->smp_pai_pppk+$this->smp_pai_gtt;
    }

    public function getSmpPaiSelisihAttribute()
    {
        return $this->smp_pai_abk+$this->smp_pai_jumlah;
    }

    public function getSmpPjokJumlahAttribute()
    {
        return $this->smp_pjok_pns+$this->smp_pjok_pppk+$this->smp_pjok_gtt;
    }

    public function getSmpPjokSelisihAttribute()
    {
        return $this->smp_pjok_abk+$this->smp_pjok_jumlah;
    }

    public function getSmpBIndonesiaJumlahAttribute()
    {
        return $this->smp_b_indonesia_pns+$this->smp_b_indonesia_pppk+$this->smp_b_indonesia_gtt;
    }

    public function getSmpBIndonesiaSelisihAttribute()
    {
        return $this->smp_b_indonesia_abk+$this->smp_b_indonesia_jumlah;
    }

    public function getSmpBInggrisJumlahAttribute()
    {
        return $this->smp_b_inggris_pns+$this->smp_b_inggris_pppk+$this->smp_b_inggris_gtt;
    }

    public function getSmpBInggrisSelisihAttribute()
    {
        return $this->smp_b_inggris_abk+$this->smp_b_inggris_jumlah;
    }

    public function getSmpBkJumlahAttribute()
    {
        return $this->smp_bk_pns+$this->smp_bk_pppk+$this->smp_bk_gtt;
    }

    public function getSmpBkSelisihAttribute()
    {
        return $this->smp_bk_abk+$this->smp_bk_jumlah;
    }

    public function getSmpIpaJumlahAttribute()
    {
        return $this->smp_ipa_pns+$this->smp_ipa_pppk+$this->smp_ipa_gtt;
    }

    public function getSmpIpaSelisihAttribute()
    {
        return $this->smp_ipa_abk+$this->smp_ipa_jumlah;
    }

    public function getSmpIpsJumlahAttribute()
    {
        return $this->smp_ips_pns+$this->smp_ips_pppk+$this->smp_ips_gtt;
    }

    public function getSmpIpsSelisihAttribute()
    {
        return $this->smp_ips_abk+$this->smp_ips_jumlah;
    }

    public function getSmpMatematikaJumlahAttribute()
    {
        return $this->smp_matematika_pns+$this->smp_matematika_pppk+$this->smp_matematika_gtt;
    }

    public function getSmpMatematikaSelisihAttribute()
    {
        return $this->smp_matematika_abk+$this->smp_matematika_jumlah;
    }

    public function getSmpPpknJumlahAttribute()
    {
        return $this->smp_pppkn_pns+$this->smp_pppkn_pppk+$this->smp_pppkn_gtt;
    }

    public function getSmpPpknSelisihAttribute()
    {
        return $this->smp_pppkn_abk+$this->smp_pppkn_jumlah;
    }

    public function getSmpPrakaryaJumlahAttribute()
    {
        return $this->smp_prakarya_pns+$this->smp_prakarya_pppk+$this->smp_prakarya_gtt;
    }

    public function getSmpPrakaryaSelisihAttribute()
    {
        return $this->smp_prakarya_abk+$this->smp_prakarya_jumlah;
    }

    public function getSmpSeniBudayaJumlahAttribute()
    {
        return $this->smp_seni_budaya_pns+$this->smp_seni_budaya_pppk+$this->smp_seni_budaya_gtt;
    }

    public function getSmpSeniBudayaSelisihAttribute()
    {
        return $this->smp_seni_budaya_abk+$this->smp_seni_budaya_jumlah;
    }

    public function getSmpBSundaJumlahAttribute()
    {
        return $this->smp_b_sunda_pns+$this->smp_b_sunda_pppk+$this->smp_b_sunda_gtt;
    }

    public function getSmpBSundaSelisihAttribute()
    {
        return $this->smp_b_sunda_abk+$this->smp_b_sunda_jumlah;
    }

    public function getSmpTikJumlahAttribute()
    {
        return $this->smp_tik_pns+$this->smp_tik_pppk+$this->smp_tik_gtt;
    }

    public function getSmpTikSelisihAttribute()
    {
        return $this->smp_tik_abk+$this->smp_tik_jumlah;
    }

    //

    public function getSdJumlahAbkAttribute()
    {
        return
            $this->sd_kelas_abk
            +$this->sd_penjaskes_abk
            +$this->sd_agama_abk;
    }

    public function getSdJumlahFormasiAttribute()
    {
        return
            $this->sd_kelas_formasi
            +$this->sd_penjaskes_formasi
            +$this->sd_agama_formasi;
    }

    public function getSdJumlahSelisihAttribute()
    {
        return
            $this->sd_jumlah_abk
            -$this->sd_jumlah_formasi;
    }

    //

    public function getSmpJumlahAbkAttribute()
    {
        return
            $this->smp_pai_abk
            +$this->smp_pjok_abk
            +$this->smp_b_indonesia_abk
            +$this->smp_b_inggris_abk
            +$this->smp_bk_abk
            +$this->smp_ipa_abk
            +$this->smp_ips_abk
            +$this->smp_matematika_abk
            +$this->smp_pppkn_abk
            +$this->smp_prakarya_abk
            +$this->smp_seni_budaya_abk
            +$this->smp_b_sunda_abk
            +$this->smp_tik_abk;
    }

    public function getSmpJumlahFormasiAttribute()
    {
        return
            $this->smp_pai_formasi
            +$this->smp_pjok_formasi
            +$this->smp_b_indonesia_formasi
            +$this->smp_b_inggris_formasi
            +$this->smp_bk_formasi
            +$this->smp_ipa_formasi
            +$this->smp_ips_formasi
            +$this->smp_matematika_formasi
            +$this->smp_pppkn_formasi
            +$this->smp_prakarya_formasi
            +$this->smp_seni_budaya_formasi
            +$this->smp_b_sunda_formasi
            +$this->smp_tik_formasi;
    }

    public function getSmpJumlahSelisihAttribute()
    {
        return
            $this->smp_jumlah_abk
            -$this->smp_jumlah_formasi;
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
