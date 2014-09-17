<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/24/2014
 * Time: 08:11
 */

namespace Ajax;


use Simdes\Repositories\SSH\JenisBarangRepositoryInterface;
use Simdes\Repositories\SSH\KelasBarangRepositoryInterface;
use Simdes\Repositories\SSH\KelompokBarangRepositoryInterface;
use Simdes\Repositories\SSH\ObyekBarangRepositoryInterface;
use Simdes\Repositories\SSH\RincianObyekBarangRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class AjaxSSHController
 *
 * @package Ajax
 */
class AjaxSSHController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\SSH\KelasBarangRepositoryInterface
     */
    private $kelasBarang;
    /**
     * @var \Simdes\Repositories\SSH\KelompokBarangRepositoryInterface
     */
    private $kelompokBarang;
    /**
     * @var \Simdes\Repositories\SSH\JenisBarangRepositoryInterface
     */
    private $jenisBarang;
    /**
     * @var \Simdes\Repositories\SSH\ObyekBarangRepositoryInterface
     */
    private $obyekBarang;
    /**
     * @var \Simdes\Repositories\SSH\RincianObyekBarangRepositoryInterface
     */
    private $rincianObyekBarang;

    /**
     * @param KelasBarangRepositoryInterface $kelasBarang
     * @param KelompokBarangRepositoryInterface $kelompokBarang
     * @param JenisBarangRepositoryInterface $jenisBarang
     * @param ObyekBarangRepositoryInterface $obyekBarang
     * @param RincianObyekBarangRepositoryInterface $rincianObyekBarang
     * @param UserRepositoryInterface $auth
     */
    public function __construct(
        KelasBarangRepositoryInterface $kelasBarang,
        KelompokBarangRepositoryInterface $kelompokBarang,
        JenisBarangRepositoryInterface $jenisBarang,
        ObyekBarangRepositoryInterface $obyekBarang,
        RincianObyekBarangRepositoryInterface $rincianObyekBarang,
        UserRepositoryInterface $auth
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->kelasBarang = $kelasBarang;
        $this->kelompokBarang = $kelompokBarang;
        $this->jenisBarang = $jenisBarang;
        $this->obyekBarang = $obyekBarang;
        $this->rincianObyekBarang = $rincianObyekBarang;
    }

    /**
     * @return mixed
     */
    public function getListKelasBarang()
    {
        return $this->kelasBarang->getListKelasBarang();
    }

    /**
     * @return mixed
     */
    public function getListKelompokBarang()
    {
        $kelas_id = $this->input('kelas_id');

        return $this->kelompokBarang->getListKelompokBarang($kelas_id);
    }

    /**
     * @return mixed
     */
    public function getListJenisBarang()
    {
        $kelompok_id = $this->input('kelompok_id');

        return $this->jenisBarang->getListJenisBarang($kelompok_id);
    }

    /**
     * @return mixed
     */
    public function getListObyekBarang()
    {
        $jenis_id = $this->input('jenis_id');

        return $this->obyekBarang->getListObyekBarang($jenis_id);
    }

    /**
     * @return array
     */
    public function autocomplete()
    {
        $term = $this->input('term');
        $data = $this->rincianObyekBarang->autocomplete($term);
        $result = [];
        if ($data) {
            foreach ($data as $value) {
                $result[] = [
                    'id'          => $value->id,
                    'value'       => trim($value->rincian_obyek),
                    'harga'       => $value->harga,
                    'satuan'      => $value->satuan,
                    'kode_barang' => $value->kode_barang,
                    'spesifikasi' => $value->spesifikasi,
                ];
            }
        } else {
            $result[] = "";
        }

        return $result;
    }

}