<?php namespace Simdes\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 *
 * @package Simdes\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // mencatat aktifitas user
        $this->app->bind(
            'Simdes\Repositories\Log\LogRepositoryInterface',
            'Simdes\Repositories\Eloquent\Log\LogRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\KelasBarangRepositoryInterface',
            'Simdes\Repositories\Eloquent\KelasBarangRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\Pendapatan\PendapatanRepositoryInterface',
            'Simdes\Repositories\Eloquent\Pendapatan\PendapatanRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\Pembiayaan\PembiayaanRepositoryInterface',
            'Simdes\Repositories\Eloquent\Pembiayaan\PembiayaanRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\Akun\AkunRepositoryInterface',
            'Simdes\Repositories\Eloquent\Akun\AkunRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\Akun\KelompokRepositoryInterface',
            'Simdes\Repositories\Eloquent\Akun\KelompokRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\Akun\JenisRepositoryInterface',
            'Simdes\Repositories\Eloquent\Akun\JenisRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\Akun\ObyekRepositoryInterface',
            'Simdes\Repositories\Eloquent\Akun\ObyekRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\Akun\RincianObyekRepositoryInterface',
            'Simdes\Repositories\Eloquent\Akun\RincianObyekRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\RPJMDesa\VisiRepositoryInterface',
            'Simdes\Repositories\Eloquent\RPJMDesa\VisiRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\RPJMDesa\RPJMDesaRepositoryInterface',
            'Simdes\Repositories\Eloquent\RPJMDesa\RPJMDesaRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\RPJMDesa\MisiRepositoryInterface',
            'Simdes\Repositories\Eloquent\RPJMDesa\MisiRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\RPJMDesa\MasalahRepositoryInterface',
            'Simdes\Repositories\Eloquent\RPJMDesa\MasalahRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\RPJMDesa\PemetaanRepositoryInterface',
            'Simdes\Repositories\Eloquent\RPJMDesa\PemetaanRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\RPJMDesa\PotensiRepositoryInterface',
            'Simdes\Repositories\Eloquent\RPJMDesa\PotensiRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\RPJMDesa\ProgramRepositoyInterface',
            'Simdes\Repositories\Eloquent\RPJMDesa\ProgramRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\Kewenangan\ProgramRepositoryInterface',
            'Simdes\Repositories\Eloquent\Kewenangan\ProgramRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\User\UserRepositoryInterface',
            'Simdes\Repositories\Eloquent\User\UserRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface',
            'Simdes\Repositories\Eloquent\Organisasi\OrganisasiRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\RKPDesa\RKPDesaRepositoryInterface',
            'Simdes\Repositories\Eloquent\RKPDesa\RKPDesaRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\Kewenangan\KegiatanRepositoryInterface',
            'Simdes\Repositories\Eloquent\Kewenangan\KegiatanRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\Kewenangan\FungsiRepositoryInterface',
            'Simdes\Repositories\Eloquent\Kewenangan\FungsiRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\RKPDesa\IndikatorMasukanRepositoryInterface',
            'Simdes\Repositories\Eloquent\RKPDesa\IndikatorMasukanRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\RKPDesa\IndikatorKeluaranRepositoryInterface',
            'Simdes\Repositories\Eloquent\RKPDesa\IndikatorKeluaranRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\RKPDesa\IndikatorHasilRepositoryInterface',
            'Simdes\Repositories\Eloquent\RKPDesa\IndikatorHasilRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\RKPDesa\IndikatorManfaatRepositoryInterface',
            'Simdes\Repositories\Eloquent\RKPDesa\IndikatorManfaatRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\Belanja\BelanjaRepositoryInterface',
            'Simdes\Repositories\Eloquent\Belanja\BelanjaRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\SSH\KelasBarangRepositoryInterface',
            'Simdes\Repositories\Eloquent\SSH\KelasBarangRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\SSH\KelompokBarangRepositoryInterface',
            'Simdes\Repositories\Eloquent\SSH\KelompokBarangRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\SSH\JenisBarangRepositoryInterface',
            'Simdes\Repositories\Eloquent\SSH\JenisBarangRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\SSH\ObyekBarangRepositoryInterface',
            'Simdes\Repositories\Eloquent\SSH\ObyekBarangRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\SSH\RincianObyekBarangRepositoryInterface',
            'Simdes\Repositories\Eloquent\SSH\RincianObyekBarangRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\RKA\RKARepositoryInterface',
            'Simdes\Repositories\Eloquent\RKA\RKARepository'
        );

        $this->app->bind(
            'Simdes\Repositories\DPA\DPARepositoryInterface',
            'Simdes\Repositories\Eloquent\DPA\DPARepository'
        );

        $this->app->bind(
            'Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface',
            'Simdes\Repositories\Eloquent\Pejabat\PejabatDesaRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\Transaksi\PendapatanRepositoryInterface',
            'Simdes\Repositories\Eloquent\Transaksi\PendapatanRepository'
        );

        $this->app->bind(
            'Simdes\Repositories\Transaksi\BelanjaRepositoryInterface',
            'Simdes\Repositories\Eloquent\Transaksi\BelanjaRepository'
        );

        // perdes judul
        $this->app->bind(
            'Simdes\Repositories\Perdes\JudulRepositoryInterface',
            'Simdes\Repositories\Eloquent\Perdes\JudulRepository'
        );

        // perdes konsideran
        $this->app->bind(
            'Simdes\Repositories\Perdes\KonsideranRepositoryInterface',
            'Simdes\Repositories\Eloquent\Perdes\KonsideranRepository'
        );

        // perdes dasar hukum
        $this->app->bind(
            'Simdes\Repositories\Perdes\DasarHukumRepositoryInterface',
            'Simdes\Repositories\Eloquent\Perdes\DasarHukumRepository'
        );

        // perdes batang tubuh
        $this->app->bind(
            'Simdes\Repositories\Perdes\BatangTubuhRepositoryInterface',
            'Simdes\Repositories\Eloquent\Perdes\BatangTubuhRepository'
        );

        // perdes penutup
        $this->app->bind(
            'Simdes\Repositories\Perdes\PenutupRepositoryInterface',
            'Simdes\Repositories\Eloquent\Perdes\PenutupRepository'
        );

        // perdes ketentuan umum
        $this->app->bind(
            'Simdes\Repositories\Perdes\KetentuanRepositoryInterface',
            'Simdes\Repositories\Eloquent\Perdes\KetentuanRepository'
        );

        // materi pokok
        $this->app->bind(
            'Simdes\Repositories\Perdes\MateriPokokRepositoryInterface',
            'Simdes\Repositories\Eloquent\Perdes\MateriPokokRepository'
        );

        // materi pokok poin
        $this->app->bind(
            'Simdes\Repositories\Perdes\MateriPokokPoinRepositoryInterface',
            'Simdes\Repositories\Eloquent\Perdes\MateriPokokPoinRepository'
        );

        // perdes ketentuan penutup
        $this->app->bind(
            'Simdes\Repositories\Perdes\KetentuanPenutupRepositoryInterface',
            'Simdes\Repositories\Eloquent\Perdes\KetentuanPenutupRepository'
        );

        // kewenangan
        $this->app->bind(
            'Simdes\Repositories\Kewenangan\KewenanganRepositoryInterface',
            'Simdes\Repositories\Eloquent\Kewenangan\KewenanganRepository'
        );

        // Bidang
        $this->app->bind(
            'Simdes\Repositories\Kewenangan\BidangRepositoryInterface',
            'Simdes\Repositories\Eloquent\Kewenangan\BidangRepository'
        );

        // Sumber dana
        $this->app->bind(
            'Simdes\Repositories\SumberDana\SumberDanaInterface',
            'Simdes\Repositories\Eloquent\SumberDana\SumberDanaRepository'
        );

    }
}