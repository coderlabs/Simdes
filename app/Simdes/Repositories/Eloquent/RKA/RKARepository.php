<?php
    /**
     * Email: edicyber@gmail.com
     * User: Edi Santoso
     * Date: 5/29/2014
     * Time: 18:45
     */

    namespace Simdes\Repositories\Eloquent\RKA;

    use Simdes\Models\Pendapatan\Pendapatan;
    use Simdes\Models\Pembiayaan\Pembiayaan;
    use Simdes\Models\Belanja\Belanja;
    use Simdes\Repositories\Akun\JenisRepositoryInterface;
    use Simdes\Repositories\Akun\KelompokRepositoryInterface;
    use Simdes\Repositories\Akun\ObyekRepositoryInterface;
    use Simdes\Repositories\Akun\RincianObyekRepositoryInterface;
    use Simdes\Repositories\Belanja\BelanjaRepositoryInterface;
    use Simdes\Repositories\Eloquent\AbstractRepository;
    use Simdes\Repositories\Pembiayaan\PembiayaanRepositoryInterface;
    use Simdes\Repositories\RKA\RKARepositoryInterface;
    use Simdes\Repositories\SSH\JenisBarangRepositoryInterface;
    use Simdes\Repositories\SSH\KelompokBarangRepositoryInterface;

    /**
     * Class RKARepository
     *
     * @package Simdes\Repositories\Eloquent\rka
     */
    class RKARepository extends AbstractRepository implements RKARepositoryInterface
    {

        /**
         * @var \Simdes\Models\Pendapatan\Pendapatan
         */
        protected $pendapatan;
        /**
         * @var \Simdes\Repositories\Belanja\BelanjaRepositoryInterface
         */
        protected $belanja;
        /**
         * @var \Simdes\Repositories\Pembiayaan\PembiayaanRepositoryInterface
         */
        protected $pembiayaan;
        /**
         * @var \Simdes\Repositories\SSH\KelompokBarangRepositoryInterface
         */
        protected $kelompok;
        /**
         * @var \Simdes\Repositories\Akun\JenisRepositoryInterface
         */
        protected $jenis;
        /**
         * @var \Simdes\Repositories\Akun\ObyekRepositoryInterface
         */
        protected $obyek;
        /**
         * @var \Simdes\Repositories\Akun\RincianObyekRepositoryInterface
         */
        protected $rincianObyek;


        /**
         * @param Pendapatan                      $pendapatan
         * @param Belanja                         $belanja
         * @param Pembiayaan                      $pembiayaan
         * @param KelompokRepositoryInterface     $kelompok
         * @param JenisRepositoryInterface        $jenis
         * @param ObyekRepositoryInterface        $obyek
         * @param RincianObyekRepositoryInterface $rincianObyek
         */
        public function __construct(Pendapatan $pendapatan,
                                    Belanja $belanja,
                                    Pembiayaan $pembiayaan,
                                    KelompokRepositoryInterface $kelompok,
                                    JenisRepositoryInterface $jenis,
                                    ObyekRepositoryInterface $obyek,
                                    RincianObyekRepositoryInterface $rincianObyek

        )
        {

            $this->pendapatan = $pendapatan;
            $this->belanja = $belanja;
            $this->pembiayaan = $pembiayaan;
            $this->kelompok = $kelompok;
            $this->jenis = $jenis;
            $this->obyek = $obyek;
            $this->rincianObyek = $rincianObyek;
        }

        /**
         * @param $organisasi_id
         *
         * @return array
         */
        public function findRKAPendapatan($organisasi_id)
        {
            $rkaPendapatan = $this->pendapatan->where('is_dpa', '=', 0)->where('is_rka', '=', 1)->where('organisasi_id','=',$organisasi_id)->get();
            return $rkaPendapatan;
        }

        /**
         * @param $organisasi_id
         *
         * @return mixed
         */
        public function findRKABelanja($organisasi_id)
        {
            $rkaBelanja = $this->belanja->where('is_dpa', '=', 0)->where('is_rka', '=', 1)->where('organisasi_id','=',$organisasi_id)->get();
            return $rkaBelanja;
        }

        /**
         * @param $organisasi_id
         *
         * @return mixed
         */
        public function findRKAPembiayaan($organisasi_id)
        {
            $rkaPembiayaan = $this->pembiayaan->where('is_dpa', '=', 0)->where('is_rka', '=', 1)->where('organisasi_id','=',$organisasi_id)->get();
            return $rkaPembiayaan;
        }

        public function getSumPendapatan($organisasi_id){
            return $this->pendapatan->where('is_dpa', '=', 0)->where('is_rka', '=', 1)->where('organisasi_id','=',$organisasi_id)->sum('jumlah');
        }

        public function getSumBelanja($organisasi_id){
            return $this->belanja->where('is_dpa', '=', 0)->where('is_rka', '=', 1)->where('organisasi_id','=',$organisasi_id)->sum('jumlah');
        }

        public function getSumPembiayaan($organisasi_id){
            return $this->pembiayaan->where('is_dpa', '=', 0)->where('is_rka', '=', 1)->where('organisasi_id','=',$organisasi_id)->sum('jumlah');
        }

        /**
         * @param $kelompok_id
         * @param $jenis_id
         * @param $obyek_id
         * @param $rincian_obyek_id
         *
         * @return array
         */
        public function getPendapatan($kelompok_id, $jenis_id, $obyek_id, $rincian_obyek_id)
        {
            if (!empty($rincian_obyek_id)) {
                $getNamaPendapatan = $this->rincianObyek->findById($rincian_obyek_id);

                return $result[] = [
                    'kode_rekening_kelompok' => $getNamaPendapatan->jenis->kelompok->kode_rekening,
                    'kelompok'               => $getNamaPendapatan->jenis->kelompok->kelompok,
                    'kode_rekening_jenis'    => $getNamaPendapatan->jenis->kode_rekening,
                    'jenis'                  => $getNamaPendapatan->jenis->jenis,
                    'kode_rekening_obyek'    => $getNamaPendapatan->obyek->kode_rekening,
                    'obyek'                  => $getNamaPendapatan->obyek->obyek->obyek,
                    'kode_rekening'          => $getNamaPendapatan->obyek->kode_rekening,
                    'rincian_obyek'          => $getNamaPendapatan->rincian_obyek,
                ];
            } elseif (!empty($obyek_id)) {
                $getNamaPendapatan = $this->obyek->findById($obyek_id);
                return $result[] = [
                    'kode_rekening_kelompok' => $getNamaPendapatan->jenis->kelompok->kode_rekening,
                    'kelompok'               => $getNamaPendapatan->jenis->kelompok->kelompok,
                    'kode_rekening_jenis'    => $getNamaPendapatan->jenis->kode_rekening,
                    'jenis'                  => $getNamaPendapatan->jenis->jenis,
                    'kode_rekening'          => $getNamaPendapatan->kode_rekening,
                    'obyek'                  => $getNamaPendapatan->obyek,
                ];
            } elseif (!empty($jenis_id)) {
                $getNamaPendapatan = $this->jenis->findById($jenis_id);

                return $result[] = [
                    'kode_rekening_kelompok' => $getNamaPendapatan->kelompok->kode_rekening,
                    'kelompok'               => $getNamaPendapatan->kelompok->kelompok,
                    'kode_rekening'          => $getNamaPendapatan->kode_rekening,
                    'jenis'                  => $getNamaPendapatan->jenis,
                ];
            } elseif (!empty($kelompok_id)) {
                $getNamaPendapatan = $this->kelompok->findById($kelompok_id);

                return $result[] = [
                    'kode_rekening' => $getNamaPendapatan->kode_rekening,
                    'kelompok'      => $getNamaPendapatan->kelompok,
                ];
            }
        }

        /**
         * @param $volume_1
         * @param $volume_2
         * @param $volume_3
         *
         * @return string
         */
        public function getVolume($volume_1, $volume_2, $volume_3)
        {
            $vol1 = ($volume_1 > 0) ? $volume_1 : '';
            $vol2 = ($volume_2 > 0) ? '/' . $volume_2 : '';
            $vol3 = ($volume_3 > 0) ? '/' . $volume_3 : '';

            return $vol1 . $vol2 . $vol3;
        }

        /**
         * @param $satuan_1
         * @param $satuan_2
         * @param $satuan_3
         *
         * @return string
         */
        public function getSatuan($satuan_1, $satuan_2, $satuan_3)
        {
            $sat1 = (!empty($satuan_1)) ? $satuan_1 : '';
            $sat2 = (!empty($satuan_2)) ? '/' . $satuan_2 : '';
            $sat3 = (!empty($satuan_3)) ? '/' . $satuan_3 : '';

            return $sat1 . $sat2 . $sat3;
        }
    }