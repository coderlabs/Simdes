<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/14/2014
 * Time: 10:24
 */

namespace Simdes\Repositories\Eloquent\RPJMDesa;


use Simdes\Models\RPJMDesa\Pemetaan;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\RPJMDesa\PemetaanRepositoryInterface;
use Simdes\Services\Forms\RPJMDesa\PemetaanEditForm;
use Simdes\Services\Forms\RPJMDesa\PemetaanForm;

/**
 * Class PemetaanRepository
 *
 * @package Simdes\Repositories\Eloquent\RPJMDesa
 */
class PemetaanRepository extends AbstractRepository implements PemetaanRepositoryInterface
{

    public function __construct(Pemetaan $pemetaan)
    {
        $this->model = $pemetaan;
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        $pemetaan = $this->getNew();

        $pemetaan->rpjmdesa_id = $data['rpjmdesa_id'];
        $pemetaan->masalah_id = $data['masalah_id'];
        $pemetaan->user_id = $data['user_id'];
        $pemetaan->organisasi_id = $data['organisasi_id'];
        $pemetaan->save();

        // return berupa pemetaan_id untuk diupdate ke
        // tabel tb_rpjm_masalah
        return $pemetaan->id;
    }

    /**
     * @param Pemetaan $pemetaan
     * @param array    $data
     *
     * @return Pemetaan
     */
    public function update(Pemetaan $pemetaan, array $data)
    {
        $pemetaan->user_id = $data['user_id'];
        $pemetaan->pemetaan_1 = $data['pemetaan_1'];
        $pemetaan->pemetaan_2 = $data['pemetaan_2'];
        $pemetaan->pemetaan_3 = $data['pemetaan_3'];
        $pemetaan->pemetaan_4 = $data['pemetaan_4'];
        $pemetaan->pemetaan_5 = $data['pemetaan_5'];
        $pemetaan->jumlah = $this->getJumlah($data['pemetaan_1'], $data['pemetaan_2'], $data['pemetaan_3'], $data['pemetaan_4'], $data['pemetaan_5']);
        $pemetaan->save();

        $pemetaan->masalah()->update([
            'sekor_pemetaan' => $pemetaan->jumlah
        ]);

        return $pemetaan;
    }

    /**
     * @param $pemetaan_1
     * @param $pemetaan_2
     * @param $pemetaan_3
     * @param $pemetaan_4
     * @param $pemetaan_5
     *
     * @return mixed
     */
    public function getJumlah($pemetaan_1, $pemetaan_2, $pemetaan_3, $pemetaan_4, $pemetaan_5)
    {
        return $pemetaan_1 + $pemetaan_2 + $pemetaan_3 + $pemetaan_4 + $pemetaan_5;
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $pemetaan = $this->findById($id);
        $pemetaan->delete();
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

    /**
     * @return PemetaanForm
     */
    public function getCreationForm()
    {
        return new PemetaanForm();
    }

    /**
     * @return PemetaanEditForm
     */
    public function getEditForm()
    {
        return new PemetaanEditForm();
    }

    /**
     * @param $id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findByFilter($id, $organisasi_id)
    {
        return $this->model->where('id', '=', $id)->where('organisasi_id', '=', $organisasi_id)->first();
    }

}