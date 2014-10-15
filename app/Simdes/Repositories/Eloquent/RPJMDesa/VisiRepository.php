<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 19:37
 */

namespace Simdes\Repositories\Eloquent\RPJMDesa;

use Simdes\Models\RPJMDesa\Visi;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\RPJMDesa\MisiRepositoryInterface;
use Simdes\Repositories\RPJMDesa\RPJMDesaRepositoryInterface;
use Simdes\Repositories\RPJMDesa\VisiRepositoryInterface;
use Simdes\Services\Forms\RPJMDesa\VisiEditForm;
use Simdes\Services\Forms\RPJMDesa\VisiForm;

/**
 * Class VisiRepository
 *
 * @package Simdes\Repositories\Eloquent\RPJMDesa
 */
class VisiRepository extends AbstractRepository implements VisiRepositoryInterface
{
    private $misi;
    /**
     * @var \Simdes\Repositories\RPJMDesa\RPJMDesaRepositoryInterface
     */
    private $RPJMDesa;


    /**
     * @param Visi $visi
     * @param RPJMDesaRepositoryInterface $RPJMDesa
     */
    public function __construct(Visi $visi, RPJMDesaRepositoryInterface $RPJMDesa, MisiRepositoryInterface $misi)
    {
        $this->model = $visi;
        $this->RPJMDesa = $RPJMDesa;
        $this->misi = $misi;
    }


    /**
     * @param $term
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findAll($term, $organisasi_id)
    {
        return $this->model
            ->orderBy('id')
            ->FullTextSearch($term)
            ->where('organisasi_id', '=', $organisasi_id)
            ->remember(10)
            ->paginate(10);
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $visi = $this->getNew();

        $visi->visi = e($data['visi']);
        $visi->user_id = $data['user_id'];
        $visi->organisasi_id = $data['organisasi_id'];
        $visi->save();

        // simpan visi_id ke tb_rpjmdesa
        // output berupa rpjmdesa_id
        // yang kemudian akan diupdate lagi ke tabel tb_rpjm_visi
        $data['visi_id'] = $visi->id;
        $data['user_id'] = $visi->user_id;
        $data['organisasi_id'] = $visi->organisasi_id;
        $rpjmdesa_id = $this->RPJMDesa->create($data);

        // update visi dengan rpjmdesa_id
        // note : jika dirasa tidak digunakan maka
        // nanti akan di disable
        $up_visi = $this->findById($visi->id);
        $data_up['rpjmdesa_id'] = $rpjmdesa_id;

        $this->updateVisi($up_visi, $data_up);

        return $visi;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function findById($id)
    {
        return $this->model->find($id)->remember(10);
    }

    /**
     * @param Visi $visi
     * @param array $data
     *
     * @return Visi
     */
    public function updateVisi(Visi $visi, array $data)
    {
        $visi->rpjmdesa_id = $data['rpjmdesa_id'];
        $visi->save();

        return $visi;
    }

    /**
     * @param Visi $visi
     * @param array $data
     *
     * @return Visi
     */
    public function update(Visi $visi, array $data)
    {
        $visi->visi = e($data['visi']);
        $visi->user_id = $data['user_id'];
        $visi->save();

        return $visi;
    }

    public function delete($id)
    {
        // get data by Id
        $visi = $this->findById($id);
        // cek apakah data dipakai oleh relasi di fungsi
        $result = $this->cekForDelete($visi->id);

        if (count($result) > 0) {
            return [
                'Status' => 'Warning',
                'msg'    => 'Data ini dipakai oleh relasi dimisi, silahkan untuk menghapus data yang ada dimisi terlebih dahulu.'
            ];
        }

        // hapus data
        $visi->delete();

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.'
        ];

    }

    public function cekForDelete($visi_id)
    {
        return $this->misi->findIsExists($visi_id);
    }

    /**
     * @return VisiForm
     */
    public function getCreationForm()
    {
        return new VisiForm();
    }

    /**
     * @return VisiEditForm
     */
    public function getEditForm()
    {
        return new VisiEditForm();
    }
}