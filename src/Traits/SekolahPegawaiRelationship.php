<?php

namespace Kanekescom\Simgtk\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Kanekescom\Simgtk\Enums\StatusKepegawaianEnum;

trait SekolahPegawaiRelationship
{
    public function pegawaiKepsek(): HasMany
    {
        return $this->pegawaiAktif()
            ->where('is_kepsek', true);
    }
    public function pegawaiPltKepsek(): HasMany
    {
        return $this->pegawaiAktif()
            ->where('is_plt_kepsek', true);
    }
    public function pegawaiJabatanKepsek(): HasMany
    {
        return $this->pegawaiAktif()
            ->where(function ($query) {
                $query->where('is_kepsek', true)
                    ->orWhere('is_plt_kepsek', true);
            });
    }

    public function pegawaiStatusKepegawaianPns(): HasMany
    {
        return $this->pegawaiAktif()
            ->where('status_kepegawaian_kode', StatusKepegawaianEnum::PNS);
    }
    public function pegawaiStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawaiAktif()
            ->where('status_kepegawaian_kode', StatusKepegawaianEnum::PPPK);
    }
    public function pegawaiStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawaiAktif()
            ->where('status_kepegawaian_kode', StatusKepegawaianEnum::NONASN);
    }

    public function pegawaiSd(): HasMany
    {
        return $this->pegawaiAktif()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', [
                    'sd_kelas',
                    'sd_penjaskes',
                    'sd_agama',
                    'sd_agama_noni',
                ]);
            });
    }

    public function pegawaiSdKelas(): HasMany
    {
        return $this->pegawaiAktif()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['sd_kelas']);
            });
    }
    public function pegawaiSdKelasStatusKepegawaianPns(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPns()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['sd_kelas']);
            });
    }
    public function pegawaiSdKelasStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPppk()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['sd_kelas']);
            });
    }
    public function pegawaiSdKelasStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawaiStatusKepegawaianGtt()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['sd_kelas']);
            });
    }

    public function pegawaiSdPenjaskes(): HasMany
    {
        return $this->pegawaiAktif()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['sd_penjaskes']);
            });
    }
    public function pegawaiSdPenjaskesStatusKepegawaianPns(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPns()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['sd_penjaskes']);
            });
    }
    public function pegawaiSdPenjaskesStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPppk()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['sd_penjaskes']);
            });
    }
    public function pegawaiSdPenjaskesStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawaiStatusKepegawaianGtt()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['sd_penjaskes']);
            });
    }

    public function pegawaiSdAgama(): HasMany
    {
        return $this->pegawaiAktif()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['sd_agama']);
            });
    }
    public function pegawaiSdAgamaStatusKepegawaianPns(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPns()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['sd_agama']);
            });
    }
    public function pegawaiSdAgamaStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPppk()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['sd_agama']);
            });
    }
    public function pegawaiSdAgamaStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawaiStatusKepegawaianGtt()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['sd_agama']);
            });
    }

    public function pegawaiSdAgamaNoni(): HasMany
    {
        return $this->pegawaiAktif()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['sd_agama_noni']);
            });
    }
    public function pegawaiSdAgamaNoniStatusKepegawaianPns(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPns()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['sd_agama_noni']);
            });
    }
    public function pegawaiSdAgamaNoniStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPppk()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['sd_agama_noni']);
            });
    }
    public function pegawaiSdAgamaNoniStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawaiStatusKepegawaianGtt()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['sd_agama_noni']);
            });
    }

    public function pegawaiSdStatusKepegawaianPns(): HasMany
    {
        return $this->pegawaiSd()
            ->where('status_kepegawaian_kode', StatusKepegawaianEnum::PNS);
    }
    public function pegawaiSdStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawaiSd()
            ->where('status_kepegawaian_kode', StatusKepegawaianEnum::PPPK);
    }
    public function pegawaiSdStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawaiSd()
            ->where('status_kepegawaian_kode', StatusKepegawaianEnum::NONASN);
    }

    public function pegawaiSmp(): HasMany
    {
        return $this->pegawaiAktif()
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

    public function pegawaiSmpPai(): HasMany
    {
        return $this->pegawaiAktif()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_pai']);
            });
    }
    public function pegawaiSmpPaiStatusKepegawaianPns(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPns()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_pai']);
            });
    }
    public function pegawaiSmpPaiStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPppk()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_pai']);
            });
    }
    public function pegawaiSmpPaiStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawaiStatusKepegawaianGtt()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_pai']);
            });
    }

    public function pegawaiSmpPjok(): HasMany
    {
        return $this->pegawaiAktif()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_pjok']);
            });
    }
    public function pegawaiSmpPjokStatusKepegawaianPns(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPns()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_pjok']);
            });
    }
    public function pegawaiSmpPjokStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPppk()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_pjok']);
            });
    }
    public function pegawaiSmpPjokStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawaiStatusKepegawaianGtt()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_pjok']);
            });
    }

    public function pegawaiSmpBIndonesia(): HasMany
    {
        return $this->pegawaiAktif()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_b_indonesia']);
            });
    }
    public function pegawaiSmpBIndonesiaStatusKepegawaianPns(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPns()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_b_indonesia']);
            });
    }
    public function pegawaiSmpBIndonesiaStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPppk()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_b_indonesia']);
            });
    }
    public function pegawaiSmpBIndonesiaStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawaiStatusKepegawaianGtt()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_b_indonesia']);
            });
    }

    public function pegawaiSmpBInggris(): HasMany
    {
        return $this->pegawaiAktif()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_b_inggris']);
            });
    }
    public function pegawaiSmpBInggrisStatusKepegawaianPns(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPns()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_b_inggris']);
            });
    }
    public function pegawaiSmpBInggrisStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPppk()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_b_inggris']);
            });
    }
    public function pegawaiSmpBInggrisStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawaiStatusKepegawaianGtt()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_b_inggris']);
            });
    }

    public function pegawaiSmpBk(): HasMany
    {
        return $this->pegawaiAktif()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_bk']);
            });
    }
    public function pegawaiSmpBkStatusKepegawaianPns(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPns()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_bk']);
            });
    }
    public function pegawaiSmpBkStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPppk()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_bk']);
            });
    }
    public function pegawaiSmpBkStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawaiStatusKepegawaianGtt()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_bk']);
            });
    }

    public function pegawaiSmpIpa(): HasMany
    {
        return $this->pegawaiAktif()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_ipa']);
            });
    }
    public function pegawaiSmpIpaStatusKepegawaianPns(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPns()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_ipa']);
            });
    }
    public function pegawaiSmpIpaStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPppk()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_ipa']);
            });
    }
    public function pegawaiSmpIpaStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawaiStatusKepegawaianGtt()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_ipa']);
            });
    }

    public function pegawaiSmpIps(): HasMany
    {
        return $this->pegawaiAktif()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_ips']);
            });
    }
    public function pegawaiSmpIpsStatusKepegawaianPns(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPns()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_ips']);
            });
    }
    public function pegawaiSmpIpsStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPppk()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_ips']);
            });
    }
    public function pegawaiSmpIpsStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawaiStatusKepegawaianGtt()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_ips']);
            });
    }

    public function pegawaiSmpMatematika(): HasMany
    {
        return $this->pegawaiAktif()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_matematika']);
            });
    }
    public function pegawaiSmpMatematikaStatusKepegawaianPns(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPns()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_matematika']);
            });
    }
    public function pegawaiSmpMatematikaStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPppk()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_matematika']);
            });
    }
    public function pegawaiSmpMatematikaStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawaiStatusKepegawaianGtt()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_matematika']);
            });
    }

    public function pegawaiSmpPpkn(): HasMany
    {
        return $this->pegawaiAktif()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_ppkn']);
            });
    }
    public function pegawaiSmpPpknStatusKepegawaianPns(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPns()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_ppkn']);
            });
    }
    public function pegawaiSmpPpknStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPppk()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_ppkn']);
            });
    }
    public function pegawaiSmpPpknStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawaiStatusKepegawaianGtt()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_ppkn']);
            });
    }

    public function pegawaiSmpPrakarya(): HasMany
    {
        return $this->pegawaiAktif()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_prakarya']);
            });
    }
    public function pegawaiSmpPrakaryaStatusKepegawaianPns(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPns()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_prakarya']);
            });
    }
    public function pegawaiSmpPrakaryaStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPppk()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_prakarya']);
            });
    }
    public function pegawaiSmpPrakaryaStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawaiStatusKepegawaianGtt()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_prakarya']);
            });
    }

    public function pegawaiSmpSeniBudaya(): HasMany
    {
        return $this->pegawaiAktif()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_seni_budaya']);
            });
    }
    public function pegawaiSmpSeniBudayaStatusKepegawaianPns(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPns()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_seni_budaya']);
            });
    }
    public function pegawaiSmpSeniBudayaStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPppk()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_seni_budaya']);
            });
    }
    public function pegawaiSmpSeniBudayaStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawaiStatusKepegawaianGtt()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_seni_budaya']);
            });
    }

    public function pegawaiSmpBSunda(): HasMany
    {
        return $this->pegawaiAktif()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_b_sunda']);
            });
    }
    public function pegawaiSmpBSundaStatusKepegawaianPns(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPns()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_b_sunda']);
            });
    }
    public function pegawaiSmpBSundaStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPppk()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_b_sunda']);
            });
    }
    public function pegawaiSmpBSundaStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawaiStatusKepegawaianGtt()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_b_sunda']);
            });
    }

    public function pegawaiSmpTik(): HasMany
    {
        return $this->pegawaiAktif()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_tik']);
            });
    }
    public function pegawaiSmpTikStatusKepegawaianPns(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPns()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_tik']);
            });
    }
    public function pegawaiSmpTikStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawaiStatusKepegawaianPppk()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_tik']);
            });
    }
    public function pegawaiSmpTikStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawaiStatusKepegawaianGtt()
            ->whereHas('mataPelajaran', function ($query) {
                $query->whereIn('kode', ['smp_tik']);
            });
    }

    public function pegawaiSmpStatusKepegawaianPns(): HasMany
    {
        return $this->pegawaiSmp()
            ->where('status_kepegawaian_kode', StatusKepegawaianEnum::PNS);
    }
    public function pegawaiSmpStatusKepegawaianPppk(): HasMany
    {
        return $this->pegawaiSmp()
            ->where('status_kepegawaian_kode', StatusKepegawaianEnum::PPPK);
    }
    public function pegawaiSmpStatusKepegawaianGtt(): HasMany
    {
        return $this->pegawaiSmp()
            ->where('status_kepegawaian_kode', StatusKepegawaianEnum::NONASN);
    }
}
